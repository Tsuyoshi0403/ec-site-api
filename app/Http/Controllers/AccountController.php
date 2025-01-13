<?php

namespace App\Http\Controllers;

use App\Exceptions\ResponseException;
use App\Services\Kinds\ErrorCode;
use App\Services\Providers\AccountSignUpProvider;
use App\Services\Providers\AccountVerifyProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * アカウント作成
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store' => 'string|required',
            'firstName' => 'string|required',
            'lastName' => 'string|required',
            'phoneNo' => 'string|nullable',
            'mail' => 'string|required',
            'pass' => 'string|required',
        ]);
        if ($validator->fails()) {
            throw new ResponseException('validate error request param.', ErrorCode::VALIDATE_ERROR_REQUEST_PARAM);
        }
        (new AccountSignUpProvider($request->all()))->generate();
        return $this->getResponse([]);
    }

    /**
     * アカウント認証
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function verity(Request $request)
    {
        return $this->getResponse([
            'isSuccess' => (new AccountVerifyProvider($request->get('t')))->generate(),
        ]);
    }
}