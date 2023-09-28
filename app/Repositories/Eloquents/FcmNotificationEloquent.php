<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\FcmNotificationResource;
use App\Models\FcmNotification;
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

    function getAll(array $data)
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
