<?php

namespace App\Exceptions;

use App\Jobs\ErrorLogJob;
use App\Services\Kinds\ErrorCode;
use App\Services\Managers\UserManager;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ResponseException extends Exception
{
    /**
     * ResponseException constructor.
     * @param $message
     * @param $code
     * @param array $alerts
     * @param array $warnings
     */
    public function __construct($message, $code)
    {
        // ハンドルファイルを追加する
        parent::__construct($message, $code);
    }

    /**
     * 例外のレポート
     *
     * @return void
     */
    public function report()
    {
        $logContext = self::makeLogContext($this);
        // 特定のエラーコードは通知される方にログ出力
        if ($this->getCode() == ErrorCode::VALIDATE_ERROR_REQUEST_PARAM) {
            Log::error($this->getMessage(), $logContext);
        } else {
            // 予期せぬエラーはログ出力する
            Log::channel('res_ex')->info($this->getMessage(), $logContext);
        }
        // エラー発生時のログをためておく
        ErrorLogJob::dispatch([
            'customerId' => $logContext['customerId'],
            'type' => $logContext['url'],
            'code' => $this->getCode(),
            'body' => $this->getMessage() . "\n" . (empty($logContext['request']) ? '' : 'request : ' . json_encode($logContext['request'])) . "\n" . $this->getTraceAsString(),
        ]);
    }

    /**
     * ログデータ生成
     * @param Exception $e
     * @return array
     */
    public static function makeLogContext(Exception $e)
    {
        $request = request();
        $logContext = [];
        if (!empty($request)) {
            $logContext['request'] = $request->toArray();
            // パスワードやファイル情報をログに保存しないようにし、ログデータが大きくならないようにリクエストから除外
            unset($logContext['request']['pass'], $logContext['request']['file']);
            foreach ($logContext['request']['files'] ?? [] as $key => $file) {
                unset($logContext['request']['files'][$key]['file']);
            }
        }
        $customerId = 0;
        
        // TODO: ResponseException実装後、再度動作しているか確認する
        // if (auth()->check()) {
        //     $customerId = UserManager::getAuth()->customerId;
        // }

        //  TODO: ResponseException実装後、再度動作しているか確認する
        // ヘルパーチェック
        if (Auth::check()) {
            // TODO: ResponseException実装後、UserManagerが動作しているか確認する
            $customerId = UserManager::getAuth()->customerId;
        }
        $logContext['customerId'] = $customerId;
        $logContext['url'] = optional($request)->url() ?? '';
        $logContext['code'] = $e->getCode();
        $logContext['trace'] = $e->getTraceAsString();
        return $logContext;
    }
}
