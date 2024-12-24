<?php

namespace App\Services\Managers;

use App\Models\MstAuthorized;
use App\Services\Traits\Storage;
use Auth;
use Exception;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class AgentManager
{
    use Storage;

    /** @var int トークンのリフレッシュ可能な有効期間(秒) */
    private const REFRESH_TTL = 3600;
    /** @var int リフレッシュトークンの期限(時) */
    private const REFRESH_TOKEN_EXPIRED_HOUR = 6;
    /** @var string 有効期限 */
    private const CLAIM_KEY_EXPIRE = 'exp';
    /** @var string リフレッシュ期限のカスタムCLAIMキー */
    private const CLAIM_KEY_REFRESH = 'refresh';
    /** @var string リフレッシュトークンフラグ */
    private const CLAIM_KEY_IS_REFRESH_TOKEN = 'isRefreshToken';

    /**
     * ペイロード取得
     * @return array
     */
    public static function payload()
    {
        try {
            /** @var Auth $auth */
            $auth = auth();
            $payload = $auth->payload();
        } catch (Exception $exception) {
            // トークンのパースができない場合は空を返却
            return [];
        }
        return json_decode($payload, true);
    }

    /**
     * トークン生成
     * @param int $customerId
     * @return string
     */
    public static function createToken($customerId = null)
    {
        if (empty($customerId)) {
            $customerId = self::payload()['sub'];
        }

        // トークン生成
        $auth = MstAuthorized::findAuth($customerId);
        return $auth ? JWTAuth::customClaims([
            self::CLAIM_KEY_REFRESH => time() + self::REFRESH_TTL,
            self::CLAIM_KEY_IS_REFRESH_TOKEN => false,
        ])->fromUser($auth) : null;
    }

    /**
     * トークンのリフレッシュ
     * @return string
     */
    public static function refreshToken()
    {
        $refresh = self::payload()[self::CLAIM_KEY_REFRESH] ?? 0;
        // リフレッシュ可能な時間を過ぎてた場合はエラー
        if ($refresh < time()) {
            return response('token invalid ', 401);
        }
        return self::createToken();
    }

    /**
     * リフレッシュトークを生成
     * @param mixed|null $customerId
     * @return string
     */
    public static function createRefreshToken($customerId)
    {
        // トークン生成
        $auth = MstAuthorized::findAuth($customerId);
        return JWTAuth::customClaims([
            self::CLAIM_KEY_EXPIRE => Carbon::now()->addHours(self::REFRESH_TOKEN_EXPIRED_HOUR)->getTimestamp(),
            self::CLAIM_KEY_IS_REFRESH_TOKEN => true,
        ])->fromUser($auth);
    }
}
