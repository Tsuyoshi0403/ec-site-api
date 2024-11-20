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

        // TODO 一時的にパスワードをハッシュ化 検証終了後に削除する
        $loginData->value = password_hash('password', PASSWORD_DEFAULT);

        if (empty($loginData) || !password_verify($password, $loginData->value)) {
            return false;
        }
        return true;
    }
}
