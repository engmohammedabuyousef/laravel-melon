<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Classes\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class UserEloquent extends Uploader
{
    private $model, $fcmToken;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    function register(array $data)
    {
        $user = new User();

        $name = substr($data['email'], 0, strpos($data['email'], '@'));

        $user->username = generateUserNameUnique($name);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->phone_number = $data['phone_number'];

        $user->save();

        if ($user->save()) {
            return $this->login(\request()->all());
        }

        return response_api(false, 422, null, empObj());
    }

    function login(array $data)
    {
        if ($data['grant_type'] == 'password') {
            \request()->request->add(['username' => $data['email']]);
        }

        $proxy = Request::create('oauth/token', 'POST');

        $response = Route::dispatch($proxy);

        $token_obj = json_decode($response->getContent());

        if (isset($token_obj->status) && !$token_obj->status) {
            return response_api(false, 422, __('auth.failed'), []);
        }

        if (isset($token_obj->error)) {
            return [
                'status' => false,
                'statusCode' => 401,
                'message' => __('auth.failed'),
                'items' => empObj()
            ];
        }

        if (!isset($token_obj->access_token)) {
            return [
                'status' => false,
                'statusCode' => 422,
                'message' => __('auth.failed'),
                'items' => empObj(),
            ];
        }

        \request()->headers->set('Accept', 'application/json');
        \request()->headers->set('Authorization', 'Bearer ' . $token_obj->access_token);

        $request = \request()->create('api/v1/profile', 'GET');

        $response = Route::dispatch($request);

        $content = json_decode($response->getContent());

        $statusCode = json_decode($response->getStatusCode());

        if ($statusCode == 200) {
            $user = $content->items;
        }

        if (!isset($user)) {
            return response_api(false, 422, __('auth.failed'), empObj());
        }

        if (!$user->is_active) {
            return response_api(false, 422, __('app.account_inactive'), empObj());
        }

        $user = $this->model->find($user->id);

        $user->last_login_at = now();

        $user->save();

        saveFcmToken($user, $data['fcm_token'], $data['device_id'], $data['device_type'], 'user');

        $token = new \stdClass();

        $token->token_type = $token_obj->token_type;
        $token->expires_in = $token_obj->expires_in;
        $token->access_token = $token_obj->access_token;
        $token->refresh_token = $token_obj->refresh_token;

        $result = [
            'token' => $token,
            'user' => new UserResource($user),
        ];

        return response_api(true, 200, null, $result);
    }

    function logout($user_id = null)
    {
        dd('logout');
        if (!isset($user_id)) {
            $user_id = authApiId();
            $token = \request()->user()->token();
            $token->revoke();
        } else {
            $access_token_id = DB::table('oauth_access_tokens')->where('user_id', '=', $user_id)->pluck('id');
            $token = DB::table('oauth_access_tokens')->where('user_id', '=', $user_id)->update(['revoked' => true]);
            DB::table('oauth_refresh_tokens')->whereIn('access_token_id', $access_token_id)->update(['revoked' => true]);
        }

        $device_reset = false;

        if (\request()->filled('device_id')) {
            $device_reset = $this->fcmToken->where('user_id', $user_id)->where('device_id', \request()->get('device_id'))->update(['status' => 'off']);
        }

        if (\request()->filled('device_type')) {
            $device_reset = $this->fcmToken->where('user_id', $user_id)->where('device_type', \request()->get('device_type'))->update(['status' => 'off']);
        }

        if (!$device_reset) {
            $this->fcmToken->where('auth_id', $user_id)->whereIn('auth_type', ['cooker', 'customer'])->update(['status' => 'off']);
        }

        if ($token) {
            return response_api(true, 200, null, empObj());
        }

        return response_api(false, 422, null, empObj());
    }

    function getById($id)
    {
        if (!isset($id) && auth('api')->check()) {
            $user = auth('api')->user();
        } else {
            $user = $this->model->find($id);
        }

        if (\request()->segment(1) == 'api' || \request()->ajax()) {
            if (isset($user)) {
                if ($user->is_active) {
                    return response_api(true, 200, null, new UserResource($user));
                } else {
                    return response_api(false, 422, __('app.account_unavailable'), $user);
                }
            }
            return response_api(false, 422, __('app.not_data_found'), []);
        }
        return new $user;
    }

    function store(array $data)
    {
        $user = new User();

        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->username = generateUserNameUnique($data['name']);

        $user->name = $data['name'];

        if (isset($data['photo'])) {
            $user->photo = $this->storeImage('users', 'photo');
        }

        if (isset($data['bio'])) {
            $user->bio = $data['bio'];
        }

        if (isset($data['phone_number'])) {
            $user->phone_number = $data['phone_number'];
        }

        if ($user->save()) {
            return redirect('/admin/users')->with('success', 'User created successfully');
        }
    }

    function update(array $data, $id)
    {
        $user = User::find($id);

        if (!isset($user)) {
            return response_api(false, 404);
        }

        $user->email = $data['email'];

        if (isset($user->name)) {
            $user->name = $data['name'];
            $user->username = generateUserNameUnique($data['name']);
        }

        if (isset($user->password)) {
            $user->password = bcrypt($data['password']);
        }

        if (isset($data['photo'])) {
            $user->photo = $this->storeImage('users', 'photo');
        }

        if (isset($data['bio'])) {
            $user->bio = $data['bio'];
        }

        if (isset($data['phone_number'])) {
            $user->phone_number = $data['phone_number'];
        }

        if ($user->save()) {
            return redirect('/admin/users')->with('success', 'User updated successfully');
        }
    }



    function editProfile(array $data)
    {
        // $message = __('app.updated');

        // $user = authApi();

        // if (isset($data['name'])) {
        //     $user->name = $data['name'];
        // }

        // if (isset($data['username'])) {
        //     // if ($user->is_change_username)
        //     //     return response_api(false, 422, __('app.once-change-username'), []);
        //     // $user->is_change_username = $user->username <> $data['username'];
        //     $user->username = $data['username'];
        // }

        // if (isset($data['phone_number'])) {
        //     $user->phone_number = $data['phone_number'];
        // }

        // if (isset($data['password'])) {

        //     // if (!isset($user->password) || isset($data['old_password']) && Hash::check($data['old_password'], $user->password)) {
        //     //     $user->password = bcrypt($data['password']);
        //     //     $message = __('app.password_updated');
        //     // } else {
        //     //     return response_api(false, 422, __('app.password_not_match'), empObj());
        //     // }
        // }

        // if (isset($data['photo'])) {
        //     // $user->photo = $this->storeImage('users', 'photo');
        // }

        // // if ($user->save()) {
        // //     return response_api(true, 200, __('app.success_action', ['action' => $message]), new UserResource($user->fresh()));
        // // }

        // return response_api(false, 422, null, empObj());
    }

    function delete($id)
    {
        $user = $this->model->find($id);
        return isset($user) && $user->delete();
    }

    /*
    function refreshToken()
    {
        $proxy = Request::create('oauth/token', 'POST');

        $response = Route::dispatch($proxy);

        $data = json_decode($response->getContent());

        $statusCode = json_decode($response->getStatusCode());

        if (isset($data->error)) {
            return [
                'status' => false,
                'statusCode' => $statusCode,
                'message' => $data->message,
                'items' => []
            ];
        }

        return [
            'status' => true,
            'statusCode' => 200,
            'message' => __('app.success'),
            'items' => [
                'token_type' => $data->token_type,
                'expires_in' => $data->expires_in,
                'access_token' => $data->access_token,
                'refresh_token' => $data->refresh_token,
            ]
        ];
    }



    function editProfile(array $data)
    {
        $message = __('app.updated');
        $user = authApi();
        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['username'])) {
            // if ($user->is_change_username)
            //     return response_api(false, 422, __('app.once-change-username'), []);
            // $user->is_change_username = $user->username <> $data['username'];
            $user->username = $data['username'];
        }
        if (isset($data['phone'])) {
            $user->phone = $data['phone'];
        }
        if (isset($data['bio'])) {
            $user->bio = $data['bio'];
        }
        if (isset($data['country_id'])) {
            $user->country_id = $data['country_id'];
        }
        if (isset($data['is_notify'])) {
            $user->is_notify = $data['is_notify'];
        }
        if (isset($data['password'])) {

            if (!isset($user->password) || isset($data['old_password']) && Hash::check($data['old_password'], $user->password)) {
                $user->password = bcrypt($data['password']);
                $message = __('app.password_updated');
            } else {
                return response_api(false, 422, __('app.password_not_match'), empObj());
            }
        }
        if (isset($data['photo'])) {
            $user->photo = $this->storeImage('users', 'photo');
        }
        if ($user->save()) {
            return response_api(true, 200, __('app.success_action', ['action' => $message]), new UserResource($user->fresh()));
        }
        return response_api(false, 422, null, empObj());
    }

    function deactivate()
    {
        $random_str = strtolower(random_strings(10));
        $user = authApi();
        $user->password = bcrypt(generateVerificationCode());
        $user->email = 'del_' . $random_str . '_' . $user->email;
        $user->username = 'del_' . $random_str . '_' . $user->username;
        $user->is_active = 0;
        $user->deleted_at = now();
        $user->linkedSocialAccounts()->delete();
        $user->save();

        $access_token_ids = DB::table('oauth_access_tokens')->where('user_id', '=', $user->id)->pluck('id');

        DB::table('oauth_access_tokens')->where('user_id', '=', $user->id)->update(['revoked' => true]);

        DB::table('oauth_refresh_tokens')->whereIn('access_token_id', $access_token_ids)->update(['revoked' => true]);

        $this->fcmToken->where('auth_id', $user->id)->whereIn('auth_type', ['customer', 'cooker'])->update(['status' => 'off']);

        return response_api(true, 200, __('app.account_unavailable'), []);
    }

    function access_token()
    {
        $count = User::where('email', request()['email'])->count();

        if ($count == 0 && request()->get('grant_type') == 'password ')
            return response_api(false, 401, __('app.no_email'), empObj());
        \request()->request->add(['username' => request()['email']]);
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = Route::dispatch($proxy);
        $token_obj = json_decode($response->getContent());

        if (isset($token_obj->error) || !isset($token_obj->access_token)) {
            $statusCode = isset($token_obj->error) ? 401 : 422;
            return response_api(false, $statusCode, __('auth.failed'), empObj());
        }

        \request()->headers->set('Accept', 'application/json');
        \request()->headers->set('Authorization', 'Bearer ' . $token_obj->access_token);


        $request = \request()->create(
            'api/profile',
            'GET'

        );
        $lang = app()->getLocale();
        $response = Route::dispatch($request);
        app()->setLocale($lang);
        $data = json_decode($response->getContent());

        $statusCode = json_decode($response->getStatusCode());
        if ($data && $data->statusCode != 200)
            return response_api(false, 422, $data->message, empObj());

        $items = $data->items;
        $user = $items ? $items->user : null;

        if (!isset($user)) {
            return response_api(false, 422, __('auth.failed'), empObj());
        }


        $user = $this->model->find($user->id);

        if (!$user->is_active && \request()->get('grant_type') == 'password')
            return response_api(false, 422, __('app.verify_code'), ['token' => empObj(), 'user' => new UserResource($user)]);

        if (!$user->is_verify_code && \request()->get('grant_type') == 'password') {

            $code = generateVerificationCode(4, $user->id);
            if (!$code)
                return response_api(false, 422, __('app.exceeded_the_number_of_times_the_code'), []);
            $user->verification_code = $code;
            $user->save();

            //send SMS
            $message = __('app.sms_verification', ['code' => $code]);
            sendSMS($message, $user->email);
            return response_api(true, 200, __('app.verify_code'), ['token' => empObj(), 'user' => new UserResource($user)]);
        }

        $token = empObj();
        //
        $token->token_type = $token_obj->token_type;
        $token->expires_in = $token_obj->expires_in;
        $token->access_token = $token_obj->access_token;
        $token->refresh_token = $token_obj->refresh_token;

        return response_api(true, 200, __('app.success'), ['token' => $token, 'user' => new UserResource($user)]);
    }

    function anyData()
    {
        $users = $this->model->latest();

        return datatables()->of($users)
            ->filter(function ($query) {
                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }


                if (request()->filled('type')) {
                    $query->where('type', request()->get('type'));
                }

                if (request()->filled('created_at')) {
                    $query->whereDate('created_at', '=', request()->get('created_at'));
                }

                if (request()->filled('is_active') || request()['is_active'] === "0") {
                    $query->where('is_active', request()['is_active']);
                }
            })
            ->editColumn('photo', function ($user) {
                return '<img src="' . $user->photo . '"  width="80px" height="80px" class="rounded-circle">';
            })
            ->addColumn('last_login_at', function ($user) {
                $last_login_time = $user->last_login_at ?? 'No login yet';

                if ($last_login_time !== 'No login yet') {
                    $last_login_time = Carbon::parse($last_login_time)->diffForHumans();
                }

                return $last_login_time;
            })

            // ->editColumn('type', function ($user) {
            //     $enumValues = DB::select("SHOW COLUMNS FROM users WHERE Field = 'type'")[0]->Type;
            //     preg_match("/^enum\(\'(.*)\'\)$/", $enumValues, $matches);
            //     $types = explode("','", $matches[1]);

            //     $dropdownHtml = '<div class="form-group"><select class="form-control select4" data-id="' . $user->id . '" name="type" id="type" style="width: 150px;">';
            //     foreach ($types as $type) {
            //         $selected = ($user->type == $type) ? "selected" : "";
            //         $dropdownHtml .= '<option value="' . $type . '" ' . $selected . '>' . $type . '</option>';
            //     }
            //     $dropdownHtml .= '</select></div>';
            //     return $dropdownHtml;
            // })
            ->editColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->diffForHumans();
            })
            ->editColumn('is_active', function ($user) {
                if ($user->is_active)
                    return '<span class="switch switch-outline switch-icon switch-success">
                <label>
                <input type="checkbox" checked="checked" name="select" class="make-switch active" name="status"
                        data-id="' . $user->id . '"/>
                <span></span>
                </label>
                    </span>';
                return '<span class="switch switch-outline switch-icon switch-success">
                        <label>
                        <input type="checkbox" name="select" class="make-switch active" name="status" data-id="' . $user->id . '"/>
                        <span></span>
                        </label>
                    </span>';
            })
            ->addColumn('action', function ($user) {
                return '<a href="' . url(admin_user_url() . '/' . $user->id . '') . '" class="btn btn-sm btn-clean btn-icon" title="View details"> <i class="la fa-eye"></i> </a>
                        <a href="' . url(admin_user_url() . '/' . $user->id . '/edit') . '" class="btn btn-sm btn-clean btn-icon edit-new-mdl" title="Edit details"> <i class="la la-edit"></i> </a>';
            })
            ->addIndexColumn()
            ->rawColumns(['is_active', 'photo', 'action', 'type'])->toJson();
    }



    function update(array $data, $id = null)
    {
        if ($id)
            $auth = User::find($id);
        else
            $auth = authApi();

        if (isset($auth)) {
            $message = __('app.success');

            if (isset($data['email'])) {
                $auth->email = $data['email'];
            }

            if (isset($data['is_cook'])) {
                $data['is_cook'] == 1 ? ($auth->type = 'cooker') : ($auth->type = 'customer');
            }

            if (isset($data['username'])) {
                $auth->username = $data['username'];
            }

            if (isset($data['name'])) {
                $auth->name = $data['name'];
            }

            if (isset($data['bio'])) {
                $auth->bio = $data['bio'];
            }

            if (isset($data['photo'])) {
                $auth->photo = $this->storeImage('user', 'photo');
            }

            if (request()->segment(1) == 'admin') {
                if (isset($data['password']))
                    $auth->password = bcrypt($data['password']);
            } elseif (request()->segment(1) == 'api') {
                if (isset($data['password'])) {
                    if (Hash::check($data['old_password'], $auth->password)) {
                        $auth->password = bcrypt($data['password']);
                        $message = __('app.password_updated');
                    } else {
                        return response_api(false, 422, __('app.password_not_match'), []);
                    }
                }
            }

            $auth->save();
            $user = $auth->fresh();
            return response_api(true, 200, $message, new UserResource($user));
        }
        return response_api(false, 422, null, []);
    }

    function enterCode(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return response_api(false, 422, __('app.mobile_not_exist'), []);
        }

        if ($user->verification_code == $data['code']) {

            $user->is_verify_code = 1;
            $user->email_verified_at = Carbon::now();
            $user->save();

            return response_api(true, 200, __('app.success'), []);
        } else
            return response_api(false, 422, __('app.incorrect_code'), []);
    }

    function ResetPassword(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response_api(false, 422, __('app.mobile_not_exist'), []);
        }

        $user->password = bcrypt($data['password']);
        $message = __('app.password_updated');
        $user->save();

        \request()->request->add(['username' => $user->email]);

        return $this->access_token();
    }

    function resendCode(array $data)
    {
        $user = $this->model->find($data['user_id']);
        if (!$user)
            return response_api(false, 422, __('app.not_found_user'), []);
        $check_mobile_is_exist = User::where('id', '=', $data['user_id'])->where('email', $data['email'])->first();
        if (!$check_mobile_is_exist)
            return response_api(false, 422, __('app.mobile_not_exist'), []);
        $code = generateVerificationCode(4, $user->id);
        if (!$code)
            return response_api(false, 422, __('app.exceeded_the_number_of_times_the_code'), []);
        $user->is_verify_code = 0;
        $user->verification_code = $code;
        $user->save();
        // Send SMS
        $message = __('app.sms_verification', ['code' => $code]);
        sendSMS($message, $user->email);
        // return Responce
        return response_api(true, 200, __('app.sent_code_verification'), []);
    }

    function confirmCode(array $data)
    {
        if (!isset($data['code'])) {
            return response_api(false, 422, __('app.incorrect_code'), []);
        }

        $user = $this->model->find($data['user_id']);
        if ($user) {
            if ($user->email != $data['email']) {
                return response_api(false, 422, __('app.incorrect_mobile'), []);
            }

            if ($user->verification_code == $data['code']) {
                $user->is_verify_code = 1;
                $user->email_verified_at = Carbon::now();
                $user->save();

                \request()->request->add(['username' => $user->email]);
                return $this->access_token();
            } else
                return response_api(false, 422, __('app.incorrect_code'), []);
        } else
            return response_api(false, 422, __('app.not_data_found'), []);
    }

    function changeStatus($id = null)
    {
        $user = isset($id) ? $this->model->find($id) : auth()->user();

        if (isset($user)) {
            $user->is_active = !$user->is_active;
            $user->save();
            $user = $user->fresh();
            if ($user->is_active == 0) {
                $access_token_id = DB::table('oauth_access_tokens')
                    ->where('user_id', '=', $id)->pluck('id');

                $token = DB::table('oauth_access_tokens')
                    ->where('user_id', '=', $id)
                    ->update(['revoked' => true]);

                DB::table('oauth_refresh_tokens')
                    ->whereIn('access_token_id', $access_token_id)
                    ->update(['revoked' => true]);
            }
            return response_api(true, 200, null, new UserResource($user));
        }
        return response_api(false, 422, null, empObj());
    }

    function changeType(array $data, $id = null)
    {
        $user = $this->model->find($id);

        if (isset($user)) {
            $user->type = $data['type'];
            $user->save();
            $user = $user->fresh();
            return response_api(true, 200, null, $user);
        }
        return response_api(false, 422, null, empObj());
    }

    function changeVerifyCode($id)
    {
        $user = $this->model->find($id);
        if (isset($user)) {
            $user->is_verify_code = !$user->is_verify_code;
            $user->save();
            $user = $user->fresh();
            if ($user->save()) {
                if ($user->is_verify_code == 0) {
                    $access_token_id = DB::table('oauth_access_tokens')
                        ->where('user_id', '=', $id)->pluck('id');

                    $token = DB::table('oauth_access_tokens')
                        ->where('user_id', '=', $id)
                        ->update(['revoked' => true]);

                    DB::table('oauth_refresh_tokens')
                        ->whereIn('access_token_id', $access_token_id)
                        ->update(['revoked' => true]);
                }
                return response_api(true, 200, null, $user);
            }
        }
        return response_api(false, 422);
    }
*/
}
