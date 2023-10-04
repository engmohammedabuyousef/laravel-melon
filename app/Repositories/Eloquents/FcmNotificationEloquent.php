<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\FcmNotificationResource;
use App\Models\FcmNotification;
use App\Models\FcmToken;
use App\Models\User;

class FcmNotificationEloquent
{
    public $model, $notificationSystem, $user, $fcmToken;

    public function __construct(FcmNotification $model, FcmTokenEloquent $fcmToken, User $user, NotificationSystemEloquent $notificationSystem)
    {
        $this->model = $model;
        $this->notificationSystem = $notificationSystem;
        $this->user = $user;
        $this->fcmToken = $fcmToken;
    }

    function index(array $data)
    {
        $page_size = isset($data['page_size']) ? $data['page_size'] : max_pagination();
        $page_number = isset($data['page_number']) ? $data['page_number'] : 1;

        $collection = $this->model->where('receiver_id', authApiId());

        $count = $collection->count();
        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('id', 'desc')->get();

        if (request()->segment(1) == 'api' || request()->ajax()) {
            return response_api(true, 200, null, FcmNotificationResource::collection($object), $page_count, $page_number, $count);
        }

        return $object;
    }

    function refreshFcmToken(array $attributes)
    {
        if (authApiId() != null) {
            $authId = authApiId();
            $authType = 'user';
        }

        $device = $this->model->where('receiver_id', $authId)->where('auth_type', $authType)->first(); // TODO: review

        if (!isset($device)) {
            $device = new FcmToken();

            $device->auth_id = $authId;

            if (isset($attributes['device_id'])) {
                $device->device_id = $attributes['device_id'];
            }

            $device->device_type = $attributes['device_type'];
        }

        $device->fcm_token = $attributes['fcm_token'];
        $device->auth_type = $authType;

        $device->save();

        return response_api(true, 200, __('app.success'), []);
    }

    function getById($id)
    {
        return $this->model->find($id);
    }

    function delete($id)
    {
        $notification = $this->model->find($id);

        if (isset($notification) && $notification->delete()) {
            return response_api(true, 200, __('app.success'), []);
        }

        return response_api(false, 422, null, []);
    }
}
