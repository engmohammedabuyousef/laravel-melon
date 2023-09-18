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

    function anyData()
    {
        $notifications = $this->model->where('action', 'public')->latest();

        return datatables()->of($notifications)
            ->filter(function ($query) {
            })
            ->editColumn('message', function ($notification) {
                return $notification->message;
            })->addColumn('delete', function ($notification) {
                return '<a href="' . url('admin/notifications/' . $notification->id) . '" class="btn btn-circle btn-icon-only red delete" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })->addIndexColumn()
            ->rawColumns(['delete'])->toJson();
    }

    function getList(array $data)
    {
        $page_size = isset($data['page_size']) ? $data['page_size'] : max_pagination(10);
        $page_number = isset($data['page_number']) ? $data['page_number'] : 1;
        $collection = $this->model->where('action', '<>', 'chat');
        $count = $collection->count();

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('created_at', 'desc')->get();

        return $object;
    }

    function getAll(array $data)
    {
        $page_size = isset($data['page_size']) ? $data['page_size'] : max_pagination();
        $page_number = isset($data['page_number']) ? $data['page_number'] : 1;
        $search_order_num = isset($data['search']) ? $data['search'] : null;

        if (request()->segment(2) == 'kitchen') {
            $collection = $this->model->where('receiver_id', auth()->user()->id)->where('type', 'kitchen')->orderBy('id', 'desc')->get();
            $data = [
                'unread_notifications_number' => $this->model->where('receiver_id', auth()->user()->id)->where('type', 'kitchen')->where('seen', 0)->count(),
                'notifications' => FcmNotificationResource::collection($collection),
            ];
            return response_api(true, 200, null, $data);
        }

        if (request()->segment(2) == 'driver') {
            $collection = $this->model->where('receiver_id', auth()->user()->id)->where('type', 'driver');
        } else {
            if (authApi()->type == 'cooker') {
                $collection = $this->model->where('receiver_id', authApiId())->where('type', 'cooker');
            } else {
                $collection = $this->model->where('receiver_id', authApiId())->where('type', 'customer');
            }
        }

        if ($search_order_num) {
            $collection = $collection->whereHas('order', function ($query) use ($search_order_num) {
                $query->where('order_num', 'LIKE', '%' . $search_order_num . '%');
            });
        }

        $count = $collection->count();
        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('id', 'desc')->get();

        if (request()->segment(1) == 'api' || request()->segment(1) == 'driver' || request()->ajax()) {
            return response_api(true, 200, null, FcmNotificationResource::collection($object), $page_count, $page_number, $count);
        }

        return $object;
    }

    function getById($id)
    {
        return $this->model->find($id);
    }

    function create(array $data)
    {
        $notification = new FcmNotification();
        $notification->sender_id = $data['sender_id'];
        $notification->action = $data['action'];
        $notification->action_id = $data['action_id'];

        if ($notification->save()) {
            return $notification;
        }

        return null;
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
