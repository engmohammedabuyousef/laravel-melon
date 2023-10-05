<?php

function empObj()
{
    return new stdClass();
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateUserNameUnique($username)
{
    if (!isset($username)) {
        $username = strtolower(generateRandomString(5));
    }
    $username = strtolower($username) . strtolower(generateRandomString(4));
    return $username;
}

function response_api($status, $statusCode, $message = null, $object = null, $page_count = null, $page = null, $count = null, $errors = null, $another_data = null)
{
    $message = isset($message) ? $message : message($statusCode);
    $error = ['status' => false, 'statusCode' => $statusCode, 'message' => $message];
    $success = ['status' => true, 'statusCode' => $statusCode, 'message' => $message];

    if ($status && isset($object)) {
        if (isset($page_count) && isset($page)) {
            $success['items'] = ['data' => $object, 'total_pages' => $page_count, 'current_page' => $page + 1, 'total_records' => $count];
        } else {
            $success['items'] = $object;
        }
    } elseif (!$status && isset($errors)) {
        $error['errors'] = $errors;
    } elseif (isset($object) || (is_array($object) && empty($object))) {
        $error['items'] = $object;
    } else {
        $success['items'] = null;
    }

    if (isset($another_data)) {
        foreach ($another_data as $key => $value) {
            $success[$key] = $value;
        }
    }

    $response = ($status) ? $success : $error;

    //    $response['post_data'] = request()->all();
    return response()->json($response);
}

function message($status_code)
{
    switch ($status_code) {
        case 200:
            return __('app.success');
        case 400:
            return __('app.error');
        case 401:
            return __('app.invalid_token');
        case 404:
            return __('app.error');
        case 422:
            return __('app.error'); //'Client input error.';
        case 500:
            return __('app.error'); //'Something went wrong. Please try again later.';
    }
    return 'Sorry! You do not have permission.';
}

function authApiId()
{
    if (auth()->guard('api')->check()) {
        return auth()->guard('api')->user()->id;
    }
    return null;
}

function authApi()
{
    if (auth()->guard('api')->check()) {
        return auth()->guard('api')->user();
    }
    return null;
}


function authAdmin()
{
    if (auth()->guard('admin')->check()) {
        return auth()->guard('admin')->user();
    }
    return null;
}

function authAdminId()
{
    if (auth()->guard('admin')->check()) {
        return auth()->guard('admin')->user()->id;
    }
    return null;
}

function assets_url()
{
    return url('assets');
}

function saveFcmToken($user, $fcmToken, $deviceId, $deviceType, $authType)
{
    if (isset($deviceType)) {
        $device = \App\Models\FcmToken::where('auth_id', $user->id)->where('device_id', $deviceId)->first();

        if (!isset($device)) {
            $device = new \App\Models\FcmToken();
        }

        $device->auth_id = $user->id;

        if (isset($deviceId)) {
            $device->device_id = $deviceId;
        }

        $device->fcm_token = $fcmToken;
        $device->device_type = $deviceType;
        $device->auth_type = $authType;

        $device->save();
    }
}

function page_count($num_object, $page_size)
{
    return ceil($num_object / (doubleval($page_size)));
}

function max_pagination($record = 10)
{
    return $record;
}

function storage_public($path)
{
    return (isset($path)) ? url('/storage/' . $path) : null;
}

function deleteAllBetween($beginning, $end, $string)
{
    $beginningPos = strpos($string, $beginning);
    $endPos = strpos($string, $end);
    if ($beginningPos === false || $endPos === false) {
        return $string;
    }

    $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

    return deleteAllBetween($beginning, $end, str_replace($textToDelete, '', $string)); // recursion to ensure all occurrences are replaced
}
