<?php

namespace App\Exceptions;

use App\Jobs\ErrorLogJob;
use App\Services\Kinds\ErrorCode;
use App\Services\Managers\UserManager;
use App\Services\MessageService;
use Illuminate\Support\Facades\Auth;
use Error;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use PDOException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Exceptions\ValidationFailedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRenderable();
        $this->registerReportable();
    }

    /** renderable関係の登録 */
    private function registerRenderable()
    {
        // TODO:時間があればDB・Redisのロールバック処理を追加する

        // 定義エラーのレスポンス情報生成
        $this->renderable(function (ResponseException $e) {
            return response()->json($e->getErrorResponse());
        });

        // ValueObjectのバリデーションエラー
        $this->renderable(function (ValidationFailedException $e) {
            $e->report();
            return response()->json($e->getErrorResponse());
        });

        // トークンが無効な場合にUnauthorizedHttpExceptionが飛んでくるので、401で返却する
        $this->renderable(function (UnauthorizedHttpException $e) {
            return response($e->getMessage(), 401);
        });

        // DBエラー
        $this->renderable(function (PDOException $e) {
            if ($e->getCode() == '42S22') {
                $exception = new ResponseException($e->getMessage(), ErrorCode::COLUMN_NOT_FOUND_ERROR);
            } else {
                $exception = new ResponseException($e->getMessage(), ErrorCode::UNDEFINED_ERROR);
            }
            return response()->json($exception->getErrorResponse());
        });


        // 未定義エラーのレスポンス情報生成
        $this->renderable(function (Exception $e) {
            $code = ErrorCode::UNDEFINED_ERROR;
            $message = MessageService::getErrorMessage($code);
            $message = 'code:[' . $code . ']\n' . $message;
            $result['error'] = [
                'code' => $code,
                'message' => $message,
            ];
            // 本番環境ではトレースは要らない
            if (env('APP_ENV') != 'prd') {
                $result['error']['stackMessage'] = $e->getMessage();
                $result['error']['stackTrace'] = $e->getTraceAsString();
            }

            return response()->json($result);
        });
        $this->renderable(function (Error $e) {
            $code = ErrorCode::UNDEFINED_ERROR;
            $message = MessageService::getErrorMessage($code);
            $message = 'code:[' . $code . ']\n' . $message;
            $result['error'] = [
                'code' => $code,
                'message' => $message,
            ];
            // 本番環境ではトレースは要らない
            if (env('APP_ENV') != 'prd') {
                $result['error']['stackMessage'] = $e->getMessage();
                $result['error']['stackTrace'] = $e->getTraceAsString();
            }

            return response()->json($result);
        });
    }

    /**
     * reportable関係の登録
     */
    private function registerReportable()
    {
        // Exceptionの出力を定義
        $this->reportable(function (Exception $e) {
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
            $logContext['url'] = $request->url();
            $logContext['trace'] = $e->getTraceAsString();
            // 予期せぬエラーはログ出力する
            Log::error($e->getMessage(), $logContext);

            $customerId = 0;
            // TODO: ResponseException実装後、再度動作しているか確認する
            if (Auth::check()) {
                $customerId = UserManager::getAuth()->customerId;
            }
            ErrorLogJob::dispatch([
                'customerId' => $customerId,
                'type' => $request->url() ?? '',
                'code' => $e->getCode(),
                'body' => $e->getMessage() . "\n" . (empty($logContext['request']) ? '' : 'request : ' . json_encode($logContext['request'])) . "\n" . $e->getTraceAsString(),
            ]);
            return false;
        });
    }
}
