<?php

namespace App\Exceptions;

use App\Jobs\ErrorLogJob;
use App\Services\Kinds\ErrorCode;
use App\Services\Managers\UserManager;
use App\Services\MessageService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResponseException extends Exception
{
    /** @var array ポップアップ時の警告メッセージ一覧 */
    private $alerts;
    /** @var bool レスポンスにalertsの内容を追加するかどうか */
    private $warnings;
    
    /**
     * ResponseException constructor.
     * @param $message
     * @param $code
     * @param array $alerts
     * @param array $warnings
     */
    public function __construct($message, $code, $alerts = [], $warnings = [])
    {
        // ハンドルファイルを追加する
        parent::__construct($message, $code);
        $this->alerts = $alerts;
        $this->warnings = $warnings;
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

    /**
     * ポップアップ情報取得
     * @return array
     */
    public function getErrorResponse()
    {
        $result = [];
        // ポップアップではない場合、エラートースト情報をレスポンスに設定する
        $message = MessageService::getErrorMessage($this->getCode());
        $message = 'code:[' . $this->getCode() . ']\n' . $message;

        if (!empty($this->alerts)) {
            $message .= "\n" . implode("\n", $this->alerts);
        }

        $result['error'] = [
            'code' => $this->getCode(),
            'message' => $message,
            'warnings' => $this->warnings,
        ];
        
        // 本番環境ではトレースは要らない
        if (env('APP_ENV') != 'prd') {
            $result['error']['stackMessage'] = $this->getMessage();
            $result['error']['stackTrace'] = $this->getTraceAsString();
        }
        return $result;
    }
}
