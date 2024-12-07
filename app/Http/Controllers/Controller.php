<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller extends BaseController
{
    /**
     * @param array $result
     * @return JsonResponse
     */
    public function getResponse($result)
    {
        // レスポンス整形
        return $this->responseJson($result);
    }
}
