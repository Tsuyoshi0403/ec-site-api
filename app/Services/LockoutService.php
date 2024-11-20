<?php

namespace App\Services;

use App\Exceptions\ResponseException;
use App\Models\LogLoginLockout;
use App\Models\TrnLoginFailed;
use App\Services\Kinds\ErrorCode;
use Carbon\Carbon;

/**
 * ロックアウトサービス
 */
class LockoutService
{
    /** @var int ロックアウト時間 */
    private const LOCKOUT_MINUTES = 30;
    /** @var int ロックアウト回数 */
    private const LOCKOUT_COUNT = 10;

    /**
     * 対象メールアドレスがロックアウトされているかチェック
     * @param string $mail メールアドレス
     * @throws ResponseException
     */
    public static function checkLockout($mail)
    {
        $loginLockout = LogLoginLockout::findByMail($mail);
        $isLockout = !empty($loginLockout) && strtotime($loginLockout->lockoutTime) >= Carbon::now()->subMinutes(self::LOCKOUT_MINUTES)->getTimestamp();
        if ($isLockout) {
            throw new ResponseException('Lockout', ErrorCode::LOGIN_LOCKOUT);
        }
    }

    /**
     * ミス回数を加算する
     * @param string $mail メールアドレス
     * @param string $api API名
     * @return void
     */
    public static function addMissCount($mail, $api)
    {
        if (empty($mail)) {
            return;
        }
        $loginFailed = TrnLoginFailed::findByMail($mail);

        if (empty($loginFailed)) {
            TrnLoginFailed::create([
                'mail' => $mail,
                'count' => 1,
            ]);
        } else {
            $count = $loginFailed->count + 1;
            $loginFailed->update(['count' => $count]);
            // ロックアウト回数に達したら、ロックアウト情報を登録
            if (($count % self::LOCKOUT_COUNT) == 0) {
                LogLoginLockout::createLockout($mail, $count, $api);
            }
        }
    }

    /**
     * ミス回数をクリアする
     * @param string $mail メールアドレス
     * @return void
     */
    public static function clearMissCount($mail)
    {
        $loginFailed = TrnLoginFailed::findByMail($mail);
        if (!empty($loginFailed)) {
            $loginFailed->delete();
        }
    }
}
