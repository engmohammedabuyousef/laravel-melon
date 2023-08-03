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
