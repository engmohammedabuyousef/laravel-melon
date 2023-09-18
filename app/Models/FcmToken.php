<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcmToken extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = ['user_id' => 'integer'];

    const TYPES = ['ios', 'android', 'web'];
    const AUTH_TYPES = ['customer', 'cooker', 'driver', 'kitchen'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    static function getReceiverToken($receiver_id, $auth_type = 'customer')
    {
        $token_android = self::where('auth_id', $receiver_id)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'android')->pluck('fcm_token')->toArray();
        $token_ios = self::where('auth_id', $receiver_id)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'ios')->pluck('fcm_token')->toArray();
        $token_web = self::where('auth_id', $receiver_id)->where('auth_type', 'kitchen')->where('status', 'on')->where('type', 'web')->pluck('fcm_token')->toArray();

        return [$token_android, $token_ios, $token_web];
    }

    static function getReceiverTokenByDevice($device_id)
    {
        $tokens = self::where('status', 'on')->where('device_id', $device_id)->pluck('fcm_token')->toArray();

        return [$tokens];
    }

    static function getDevices($receiver_id, $auth_type = 'customer')
    {
        $devices = [];
        $device_android_id = self::where('auth_id', $receiver_id)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'android')->orderByDesc('updated_at')->first();
        $device_ios_id = self::where('auth_id', $receiver_id)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'ios')->orderByDesc('updated_at')->first();
        $device_web_id = self::where('auth_id', $receiver_id)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'web')->orderByDesc('updated_at')->first();

        if ($device_android_id) {
            $devices[] = $device_android_id->device_id;
        }
        if ($device_ios_id) {
            $devices[] = $device_ios_id->device_id;
        }
        if ($device_web_id) {
            $devices[] = $device_web_id->device_id;
        }

        return $devices;
    }

    static function getReceiverTokenArray($receiver_ids, $auth_type = 'customer')
    {
        $token_android = self::whereIn('auth_id', $receiver_ids)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'android')->pluck('fcm_token')->toArray();
        $token_ios = self::whereIn('auth_id', $receiver_ids)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'ios')->pluck('fcm_token')->toArray();
        $token_web = self::whereIn('auth_id', $receiver_ids)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'web')->pluck('fcm_token')->toArray();

        return [$token_android, $token_ios, $token_web];
    }

    static function getDevicesArray($receiver_ids, $auth_type = 'customer')
    {
        $devices = [];
        $device_android_id = self::whereIn('auth_id', $receiver_ids)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'android')->orderByDesc('updated_at')->first();
        $device_ios_id = self::whereIn('auth_id', $receiver_ids)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'ios')->orderByDesc('updated_at')->first();
        $device_web_id = self::whereIn('auth_id', $receiver_ids)->where('auth_type', $auth_type)->where('status', 'on')->where('type', 'web')->orderByDesc('updated_at')->first();

        if ($device_android_id) {
            $devices[] = $device_android_id->device_id;
        }
        if ($device_ios_id) {
            $devices[] = $device_ios_id->device_id;
        }
        if ($device_web_id) {
            $devices[] = $device_web_id->device_id;
        }
        return $devices;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }
}
