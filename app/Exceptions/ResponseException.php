<?php

namespace App\Exceptions;

use App\Jobs\ErrorLogJob;
use App\Services\Kinds\ErrorCode;
use App\Services\Managers\ChatWorkManager;
use App\Services\Managers\UserManager;
use App\Services\MessageService;
use Exception;
use Log;

class ResponseException extends Exception
{
    /** @var string ポップアップ時の警告メッセージ一覧 */
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

    # TODO:loginApiが完成したら例外処理を追加する

    // /**
    //  * 例外のレポート
    //  *
    //  * @return void
    //  */
    // public function report()
    // {
    //     $logContext = self::makeLogContext($this);
    //     // 特定のエラーコードは通知される方にログ出力
    //     if ($this->getCode() == ErrorCode::VALIDATE_ERROR_REQUEST_PARAM) {
    //         Log::error($this->getMessage(), $logContext);
    //     } elseif ($this->getCode() == ErrorCode::HAVE_NO_AUTHORITY) {
    //         ChatWorkManager::sendMessage("「対象機能のアクセス権限がないため、実行できません。」のエラーが発生しました。\n{$this->getMessage()}\n[code]\n" . print_r($logContext, true) . "\n[/code]", ChatWorkManager::LOCATION_ROOM_ID);
    //     } else {
    //         // 予期せぬエラーはログ出力する
    //         Log::channel('res_ex')->info($this->getMessage(), $logContext);
    //     }
    //     // エラー発生時のログをためておく
    //     ErrorLogJob::dispatch([
    //         'employeeId' => $logContext['employeeId'],
    //         'type' => $logContext['url'],
    //         'code' => $this->getCode(),
    //         'body' => $this->getMessage() . "\n" . (empty($logContext['request']) ? '' : 'request : ' . json_encode($logContext['request'])) . "\n" . $this->getTraceAsString(),
    //     ]);
    // }

    // /**
    //  * ログデータ生成
    //  * @param Exception $e
    //  * @return array
    //  */
    // public static function makeLogContext(Exception $e)
    // {
    //     $request = request();
    //     $logContext = [];
    //     if (!empty($request)) {
    //         $logContext['request'] = $request->toArray();
    //         // パスワードがログに保存されてしまうのを防ぐ
    //         // ログデータが大きくなりすぎるためファイルを保存しない
    //         unset($logContext['request']['pass'], $logContext['request']['file']);
    //         foreach ($logContext['request']['files'] ?? [] as $key => $file) {
    //             unset($logContext['request']['files'][$key]['file']);
    //         }
    //     }
    //     $employeeId = 0;
    //     if (auth()->check()) {
    //         $employeeId = UserManager::getAuth()->employeeId;
    //     }
    //     $logContext['employeeId'] = $employeeId;
    //     $logContext['url'] = optional($request)->url() ?? '';
    //     $logContext['code'] = $e->getCode();
    //     $logContext['trace'] = $e->getTraceAsString();
    //     return $logContext;
    // }

    // /**
    //  * ポップアップの警告メッセージ取得
    //  * @return bool
    //  */
    // public function getAlerts()
    // {
    //     return $this->alerts;
    // }

    // /**
    //  * ポップアップ情報取得
    //  * @return array
    //  */
    // public function getPopupData()
    // {
    //     return [];
    // }

    // /**
    //  * ポップアップ情報取得
    //  * @return array
    //  */
    // public function getErrorResponse()
    // {
    //     $result = [];
    //     // TODO s-aoki : React/ReactNative 側でポップアップの対応が完了したらerrorは消すか検討する。
    //     // ポップアップではない場合、エラートースト情報をレスポンスに設定する
    //     $message = MessageService::getErrorMessage($this->getCode());
    //     $message = 'code:[' . $this->getCode() . ']\n' . $message;

    //     // TODO 暫定でアラートをメッセージに追加。クライアントポップアップ実装後削除
    //     if (!empty($this->alerts)) {
    //         $message .= "\n" . implode("\n", $this->alerts);
    //     }

    //     $result['error'] = [
    //         'code' => $this->getCode(),
    //         'message' => $message,
    //         'warnings' => $this->warnings,
    //     ];

    //     // ポップアップレスポンスの場合、ポップアップ情報をレスポンスに設定する
    //     if (!empty($popupData = $this->getPopupData())) {
    //         $result['error']['popupData'] = $popupData;
    //     }
    //     // 本番環境ではトレースは要らない
    //     if (env('APP_ENV') != 'prd') {
    //         $result['error']['stackMessage'] = $this->getMessage();
    //         $result['error']['stackTrace'] = $this->getTraceAsString();
    //     }
    //     return $result;
    // }
}
