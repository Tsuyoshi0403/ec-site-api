<?php

namespace App\Services\Managers;

use App\Models\MstAuthorized;
use App\Models\MstCustomer;
use App\Services\Traits\Storage;

class UserManager
{
    use Storage;

    /** @var string 認証情報の保存キー */
    private const AUTH_KEY = 'auth';
    /** @var string 顧客情報の保存キー */
    private const CUSTOMER_KEY = 'customer';

    /**
     * 保存情報を飛ばす
     */
    public static function flash()
    {
        self::flashStorage();
    }

    /**
     * 認証情報取得
     * @return MstAuthorized
     */
    public static function getAuth()
    {
        if (!self::getStorage()->exists(self::AUTH_KEY)) {
            /** @var MstAuthorized $auth */
            $auth = auth()->user();
            self::setAuth($auth);
        }
        return self::getStorage()->get(self::AUTH_KEY);
    }

    /**
     * 認証情報設定
     * @param MstAuthorized $auth 認証情報
     */
    public static function setAuth($auth)
    {
        self::getStorage()->put(self::AUTH_KEY, $auth);
    }

    /**
     * 顧客情報取得
     * @return MstCustomer
     */
    public static function getCustomer()
    {
        if (!self::getStorage()->exists(self::CUSTOMER_KEY)) {
            self::setCustomer(MstCustomer::findCustomer(self::getAuth()->customerId));
        }
        return self::getStorage()->get(self::CUSTOMER_KEY);
    }

    /**
     * 顧客情報設定
     * @param MstCustomer $customer
     */
    public static function setCustomer($customer)
    {
        self::getStorage()->put(self::CUSTOMER_KEY, $customer);
    }


    /**
     * PCのOS情報取得
     * @param string $agent
     * @return string
     */
    public static function extractWebOs($agent)
    {
        $os = '';
        if (is_null($agent)) {
            return $os;
        }

        if (preg_match('/Windows/', $agent)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac OS X/', $agent)) {
            $os = 'Mac';
        } elseif (preg_match('/Linux/', $agent, $matches)) {
            $os = 'Linux';
        } elseif (preg_match('/OS/', $agent, $matches)) {
            $os = 'iOS ' . str_replace('_', '.', $matches[1] ?? '');
        } elseif (preg_match('/Android/', $agent, $matches)) {
            $os = 'Android ' . ($matches[1] ?? '');
        }
        return $os;
    }

    /**
     * ブラウザ情報取得
     * @param string $agent
     * @return string
     */
    public static function extractBrowser($agent)
    {
        $browser = '';
        if (is_null($agent)) {
            return $browser;
        }

        if (preg_match('/Edge/', $agent) || preg_match('/Edg/', $agent)) {
            $browser = 'Microsoft Edge';
        } elseif (preg_match('/Trident/', $agent) || preg_match('/MSIE/', $agent)) {
            $browser = 'Microsoft Internet Explorer';
        } elseif (preg_match('/OPR/', $agent) || preg_match('/Opera/', $agent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Chrome/', $agent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/Firefox/', $agent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari/', $agent)) {
            $browser = 'Safari';
        }
        return $browser;
    }
}
