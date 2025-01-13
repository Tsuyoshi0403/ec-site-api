<?php

namespace App\Services\Managers;

use App\Exceptions\ResponseException;
use App\Models\LogSendMail;
use App\Services\Kinds\ErrorCode;
use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * メール管理クラス
 */
class MailManager
{
    /** @var string お知らせメールアドレス */
    public const INFO_MAIL_ADDRESS = 'dev-no-reply-info@example.com';    
    /** @var string メールアドレス形式の正規表現 */
    private const REG = '/^[A-Za-z0-9]{1}[A-Za-z0-9_+?\/.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,256}$/';

    /**
     * メール送信を送信
     * @param string $mailAddress メールアドレス
     * @param Mailable $mailable Mailable
     * @param bool $isForce 環境無視の強制送信フラグ
     */
    public static function sendMail($mailAddress, $mailable, $isForce = false)
    {
        if (!preg_match(self::REG, $mailAddress)) {
            throw new ResponseException('mail format error', ErrorCode::ILLEGAL_PARAM);
        }

        // 本番環境でのみメール送信を行う
        if (env('APP_ENV') === 'prd' || $isForce) {
            Mail::to($mailAddress)->send($mailable);
        }

        // ログ登録
        try {
            // 開発環境などでメール送信を実施していない場合、件名が空になるのでbuildを実行
            if (empty($mailable->subject)) {
                $mailable?->build();
            }
            $storeId = auth()->check() ? UserManager::getAuth()?->storeId : 0;
            LogSendMail::create([
                'from' => env('MAIL_FROM_ADDRESS') ?? '',
                'to' => $mailAddress ?? '',
                'subject' => $mailable->subject ?? '',
                'body' => $mailable->render() ?? '',
                'storeId' => $storeId,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage(), [$e->getTraceAsString()]);
        }
    }

    /**
     * メールアドレスのバリデーション
     * @param string $mail
     * @return bool
     */
    public static function isValid($mail): bool
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL) !== false;
    }
}
