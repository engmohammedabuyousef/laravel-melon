<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\FcmNotificationEloquent;
use Illuminate\Http\Request;

class FcmNotificationController extends Controller
{
    private $model;

    public function __construct(FcmNotificationEloquent $fcmNotificationEloquent)
    {
        $this->model = $fcmNotificationEloquent;
    }

    public function index(Request $request)
    {
        return $this->model->index($request->all());
    }

    public function refreshFcmToken(Request $request)
    {
        return $this->model->refreshFcmToken($request->all());
    }
}
