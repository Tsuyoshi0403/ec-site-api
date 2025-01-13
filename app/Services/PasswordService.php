<?php

namespace App\Services;

use App\Models\TrnLogin;
use App\Services\Kinds\LoginKind;

/**
 * パスワード関係のサービスクラス
 */
class PasswordService
{
    /**
     * 有効なパスワードかチェック
     * @param int $customerId 顧客ID
     * @param int $storeId 店舗ID
     * @param string $password パスワード
     * @return bool
     */
    public static function checkPassword($customerId, $storeId, $password)
    {
        
        $loginData = TrnLogin::findByCustomerIdAndKind($customerId, LoginKind::PASSWORD);


        if (empty($loginData) || !password_verify($password, $loginData->value)) {
            return false;
        }
        return true;
    }

    /**
     * パスワードのパターンがあっているかチェック
     * ※英字/数字/記号を2種類以上含む8文字以上32文字以下
     * @param string $password パスワード
     * @return false
     */
    public static function checkPasswordPattern($password)
    {
        $pattern = '#^((?=.*[a-zA-Z])(?=.*[0-9])|(?=.*[a-zA-Z])(?=.*[!-/:-@¥[-`{-~])|(?=.*[0-9])(?=.*[a-zA-Z])|(?=.*[0-9])(?=.*[!-/:-@¥[-`{-~])|(?=.*[!-/:-@¥[-`{-~])(?=.*[a-zA-Z])|(?=.*[!-/:-@¥[-`{-~])(?=.*[0-9]))([a-zA-Z0-9!-/:-@¥[-`{-~]){8,}$#';
        return (bool)preg_match($pattern, $password);
    }
}
