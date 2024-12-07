<?php

namespace App\Services\Utilities;

class AccessClientUtil
{
    /**
     * 接続クライアントのIP取得
     * @return string
     */
    public static function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_X_ORIGINAL_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_ORIGINAL_FORWARDED_FOR'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ip_array = explode(',', $ip);
            return $ip_array[0];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * ヘッダー情報取得
     * @param $key
     * @return string
     */
    public static function getHeaderKey($key)
    {
        $headers = getallheaders();
        return $headers[$key] ?? null;
    }
}
