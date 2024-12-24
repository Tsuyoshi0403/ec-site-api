<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Kinds\DeviceKind;
use App\Services\LoginService;
use App\Services\Managers\AgentManager;
use App\Services\Managers\UserManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class UserController extends Controller
{
    /**
     * ログイン処理
     * @param Request $req
     * @return JsonResponse
     * @throws Throwable
     */
    public function login(Request $req)
    {
        return $this->getResponse((new LoginService($req))->login());
    }

    /**
     * トークンのリフレッシュを行う
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function refreshToken()
    {
        // クレームにisRefreshが入っていなければエラー
        $payload = AgentManager::payload();
        $deviceKind = request()->header('Device-Kind', DeviceKind::WEB);
        if ($deviceKind === DeviceKind::WEB) {
            if (empty($payload['isRefreshToken'])) {
                return response('token invalid', 401);
            }
            // 有効期限チェック
            if ($payload['exp'] < time()) {
                return response('expired refresh token', 401);
            }
        }
        try {
            $result = [];
            if ($deviceKind != DeviceKind::WEB) {
                $result['jtkn'] = JWTAuth::customClaims([
                    'exp' => Carbon::now()->addDays(6)->getTimestamp(),
                ])->fromUser(UserManager::getAuth());
            } else {
                /** @var Auth $auth */
                $result['jtkn'] = JWTAuth::customClaims(['isRefreshToken' => false])->fromUser(UserManager::getAuth());
            }
            return $this->getResponse($result);
        } catch (Exception $e) {
            return response('token invalid ', 401);
        }
    }

    public function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
        
        $token = $user->createToken('my-app-token')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }
}
