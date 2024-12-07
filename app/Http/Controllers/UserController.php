<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\LoginService;
use Illuminate\Support\Facades\Hash;

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
