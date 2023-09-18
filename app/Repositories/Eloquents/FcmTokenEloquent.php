<?php

namespace App\Repositories\Eloquents;

use App\Models\FcmToken;

class FcmTokenEloquent
{
    private $model;

    public function __construct(FcmToken $model)
    {
        $this->model = $model;
    }

    function getReceiverToken($authId)
    {
        $androidTokens = $this->model->where('auth_id', $authId)->where('type', 'android')->pluck('fcm_token')->toArray();
        $iosTokens = $this->model->where('auth_id', $authId)->where('type', 'ios')->pluck('fcm_token')->toArray();
        $webTokens = $this->model->where('auth_id', $authId)->where('type', 'ios')->pluck('fcm_token')->toArray();

        return [$androidTokens, $iosTokens, $webTokens];
    }

    function refreshFcmToken(array $data)
    {
        if (authApiId() != null) {
            $authId = authApiId();
            $authType = authApi()->type;
        }

        $device = $this->model->where('auth_id', $authId)->where('auth_type', $authType)->where('device_id', $data['device_id'])->first();

        if (!isset($device)) {
            $device = new FcmToken();

            $device->auth_id = $authId;

            if (isset($data['device_id'])) {
                $device->device_id = $data['device_id'];
            }

            $device->type = $data['device_type'];
        }

        $device->fcm_token = $data['fcm_token'];
        $device->auth_type = $authType;

        $device->save();

        return response_api(true, 200, __('app.success'), []);
    }
}
