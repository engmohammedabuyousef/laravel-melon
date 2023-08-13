<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterUserRequest;
use App\Repositories\Eloquents\UserEloquent;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(UserEloquent $userEloquent)
    {
        $this->user = $userEloquent;
    }

    public function register(RegisterUserRequest $request)
    {
        return $this->user->register($request->all());
    }

    public function login(Request $request)
    {
        return $this->user->login($request->all());
    }

    public function profile($id = null)
    {
        return $this->user->getById($id);
    }

    public function editProfile(Request $request)
    {
        return $this->user->editProfile($request->all());
    }

    public function logout(Request $request)
    {
        return $this->user->logout($request->all());
    }
}
