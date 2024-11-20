<?php

namespace App\Services;

use App\Exceptions\ResponseException;

use App\Models\MstAuthorized;
use App\Models\MstCustomer;
use App\Services\Kinds\DeviceKind;
use App\Services\Kinds\ErrorCode;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

use function request;

/**
 * ログイン関係のサービス
 */
class LoginService
{
    /** @var float リフレッシュトークン期限(712時間) */
    private const REFRESH_TOKEN_EXPIRE_TIME = 60 * 712;
    /** @var string ログインタイプ */
    private $type;
    /** @var string ログインID */
    private $id;
    /** @var string ログインパスワード */
    private $pass;

    /**
     * LoginService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->type = $request->get('type');
        $this->id = $request->get('id');
        $this->pass = $request->get('pass');
    }

    /**
     * ログイン処理を行いトークンを発行
     * @return array
     */
    public function login()
    {
        switch ($this->type) {
            case 'pass':
                $authData = $this->idPassLogin();
                break;
            default:
                throw new ResponseException('login failed illegal route.', ErrorCode::LOGIN_FAILED_ILLEGAL_ROUTE);
        }

        // MstAuthorized をもとにログイン可能ユーザかチェックする
        if (!$this->checkLogin($authData)) {
            throw new ResponseException('login failed.', ErrorCode::LOGIN_FAILED);
        }

        $deviceKind = request()->header('Device-Kind', DeviceKind::WEB);
        
        if ($deviceKind == DeviceKind::WEB) {
            $jtkn = JWTAuth::fromUser($authData);
        } else {
            // リフレッシュトークンが入っていないので期限を6日間にする
            $jtkn = JWTAuth::customClaims([
                'exp' => Carbon::now()->addDays(6)->getTimestamp(),
            ])->fromUser($authData);
        }
        return [
            // アクセストークン
            'jtkn' => $jtkn,
            // リフレッシュトークン
            'refJtkn' => JWTAuth::customClaims([
                'exp' => Carbon::now()->addMinutes(env('JWT_REFRESH_TOKEN_TTL', self::REFRESH_TOKEN_EXPIRE_TIME))->getTimestamp(),
                'isRefreshToken' => true,
            ])->fromUser($authData),
        ];
    }

    /**
     * ログイン可能なユーザかチェックする
     * @param MstAuthorized $authData
     * @return bool
     */
    public function checkLogin($authData)
    {
        $customer = MstCustomer::findCustomer($authData->customerId);
        // 顧客情報が存在するかチェック
        if (empty($customer)) {
            return false;
        }
        return true;
    }

    /**
     * ID/PSS認証を行いMstAuthorizedの情報を取得
     *
     * @return MstAuthorized
     *
     * @throws BindingResolutionException
     * @throws ResponseException
     */
    private function idPassLogin()
    {
        LockoutService::checkLockout($this->id);
        $authData = MstAuthorized::findMail($this->id);
        if (empty($authData)) {
            LockoutService::addMissCount($this->id, 'login');
            // 指定されたIDが見つからない場合
            throw new ResponseException('login failed none id.', ErrorCode::LOGIN_FAILED_NONE_ID);
        }

        if (!PasswordService::checkPassword($authData->customerId, $authData->storeId, $this->pass)) {
            LockoutService::addMissCount($this->id, 'login');
            // 指定されたパスワードが異なっている場合
            throw new ResponseException('login failed different pass.', ErrorCode::LOGIN_FAILED_DIFFERENT_PASS);
        }

        LockoutService::clearMissCount($this->id);
        return $authData;
    }
}
