<?php

namespace App\Repositories\Eloquents;

use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;

use App\Models\FcmNotification;
use App\Models\FcmToken;
use App\Models\User;

class NotificationSystemEloquent
{
    private $devicesIds;

    public function sendNotification($authId, $receiverType = 'user', $actionId, $action, $message = null, $deviceId = null)
    {
        $model = new self;

        $receiver = null;

        if (isset($authId)) {
            if ($receiverType == 'user') {
                $receiver = User::find($authId);
            }
        }

        if (isset($receiver) && $receiver->is_active == 1) {
            if (isset($receiver)) {
                $tokens = FcmToken::getReceiverToken($authId, $receiverType);
                $model->devicesIds = FcmToken::getDevices($authId, $receiverType);
            } else {
                $tokens = FcmToken::getReceiverTokenByDevice($deviceId);
                $model->devicesIds = $deviceId;
                $authId = null;
            }

            if (count($tokens) > 0) {
                $data = [
                    'auth_id' => $authId,
                    'action_id' => $actionId,
                    'action' => $action,
                    'type' => $receiverType,
                    'title' => $message ?? null,
                ];

                $notSavedNotifications = [];

                if (!in_array($action, $notSavedNotifications)) {
                    $model->create($data);
                }

                $badge = $model->getCountUnseen($authId);

                $data = new \stdClass();

                $data->title = env('APP_NAME');

                $data->action_id = intval($actionId);

                $data->action = $action;

                if (isset($message)) {
                    $data->message = $message;
                } else {
                    $data->message =  $model->getActionTrans($action, [], $receiver ? $receiver->lang : 'ar');
                }

                try {
                    if (count($tokens[0]) > 0 || count($tokens[1]) > 0 || count($tokens[2]) > 0 || count($model->devicesIds) > 0) {
                        return $model->FCM($data->title, $data->message, $data, $tokens, $badge);
                    }
                } catch (\Throwable $e) { // For PHP 7
                    return $e;
                } catch (\Exception $e) { // For PHP 5
                    return $e;
                }
            }
        }
    }

    public function FCM($title, $body, $data, $tokens, $badge)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)->setSound('default')->setBadge($badge);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $data]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // Android
        if (count($tokens[0]) > 0) {
            $downstreamResponseForAndroid = FCM::sendTo($tokens[0], $option, null, $data);

            $downstreamResponseForAndroid->tokensToDelete();
            $downstreamResponseForAndroid->tokensToModify();
            $downstreamResponseForAndroid->tokensToRetry();
            $downstreamResponseForAndroid->tokensWithError();
        }

        // IOS
        if (count($tokens[1]) > 0) {
            $downstreamResponseForIOS = FCM::sendTo($tokens[1], $option, $notification, $data);

            $downstreamResponseForIOS->tokensToDelete();
            $downstreamResponseForIOS->tokensToModify();
            $downstreamResponseForIOS->tokensToRetry();
            $downstreamResponseForIOS->tokensWithError();
        }

        // Web
        if (count($tokens[2]) > 0) {
            $downstreamResponseForWeb = FCM::sendTo($tokens[2], $option, $notification, $data);
            $downstreamResponseForWeb->tokensToDelete();
            $downstreamResponseForWeb->tokensToModify();
            $downstreamResponseForWeb->tokensToRetry();
            $downstreamResponseForWeb->tokensWithError();
        }

        $object = [
            'number_of_success_notifications' => (isset($downstreamResponseForAndroid) ? $downstreamResponseForAndroid->numberSuccess() : 0) + (isset($downstreamResponseForIOS) ? $downstreamResponseForIOS->numberSuccess() : 0) + (isset($downstreamResponseForWeb) ? $downstreamResponseForWeb->numberSuccess() : 0),
            'number_of_failure_notifications' => (isset($downstreamResponseForAndroid) ? $downstreamResponseForAndroid->numberFailure() : 0) + (isset($downstreamResponseForIOS) ? $downstreamResponseForIOS->numberFailure() : 0) + (isset($downstreamResponseForWeb) ? $downstreamResponseForWeb->numberFailure() : 0),
            'number_of_modification_notifications' => (isset($downstreamResponseForAndroid) ? $downstreamResponseForAndroid->numberModification() : 0) + (isset($downstreamResponseForIOS) ? $downstreamResponseForIOS->numberModification() : 0) + (isset($downstreamResponseForWeb) ? $downstreamResponseForWeb->numberModification() : 0),
        ];

        return $object;
    }

    public function FCMTopic($topicNames, $title, $body, $data, $deviceType)
    {
        if (count($topicNames) == 0) {
            return response_api(false, 422, null, []);
        }

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)->setSound('default')->setBadge(1);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $data]);
        $data = $dataBuilder->build();

        $notification = $notificationBuilder->build();

        $topic = new Topics();

        if (isset($topicNames[1])) {
            $topic->topic($topicNames[0])->orTopic($topicNames[1]);
        } else {
            $topic->topic($topicNames[0]);
        }

        if ($deviceType == 'ios') {
            $topicResponse = FCM::sendToTopic($topic, null, $notification, $data);
        }

        if ($deviceType == 'android') {
            $topicResponse = FCM::sendToTopic($topic, null, null, $data);
        }

        if ($deviceType == 'web') {
            $topicResponse = FCM::sendToTopic($topic, null, $notification, $data);
        }

        $object = [
            'number_of_success_notifications' => $topicResponse->isSuccess(),
            'number_of_failure_notifications' => $topicResponse->shouldRetry(),
            'number_of_modification_notifications' => $topicResponse->error(),
        ];

        return response_api(true, 200, null, $object);
    }

    public function getActionTrans($action, $data, $local)
    {
        return __('messages.notifications.' . $action, $data, $local);
    }

    public function getTitleTrans($action, $actionId, $local)
    {
        return __('messages.notifications.' . $action, ['action_id' => '#' . $actionId], $local);
    }

    function create(array $data)
    {
        $notification = new FcmNotification();

        $notification->receiver_id = $data['receiver_id'];
        $notification->action = $data['action'];
        $notification->action_id = $data['action_id'];
        $notification->type = $data['type'];

        return $notification->save() ? $notification : null;
    }

    public function getCountUnseen($authId)
    {
        return FcmNotification::where('receiver_id', $authId)->where('seen', 0)->count();
    }
}
