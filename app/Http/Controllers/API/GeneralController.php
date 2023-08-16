<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function lookups()
    {
        $data = [
            'app_name' => env('APP_NAME'),
        ];

        return response_api(true, 200, null, $data);
    }
}
