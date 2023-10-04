<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterUserRequest;
use App\Repositories\Eloquents\UserEloquent;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $model;

    public function __construct(UserEloquent $userEloquent)
    {
        $this->model = $userEloquent;
    }

    public function register(RegisterUserRequest $request)
    {
        return $this->model->register($request->all());
    }

    public function login(Request $request)
    {
        return $this->model->login($request->all());
    }

    public function refreshToken(Request $request)
    {
        return $this->model->refreshToken($request->all());
    }

    public function profile($id = null)
    {
        return $this->model->getById($id);
    }

    public function editProfile(Request $request)
    {
        return $this->model->editProfile($request->all());
    }

    public function logout(Request $request)
    {
        return $this->model->logout($request->all());
    }
}
