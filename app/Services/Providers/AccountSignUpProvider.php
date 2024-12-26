<?php

namespace App\Services\Providers;

use App\Exceptions\ResponseException;
use App\Mail\SignUpMail;
use App\Models\MstAuthorized;
use App\Models\TrnSignUp;
use App\Services\Kinds\ErrorCode;
use App\Services\Managers\MailManager;
use App\Services\PasswordService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Class AccountSignUpProvider
 */
class AccountSignUpProvider
{
    /** @var string[] パラメータ */
    private array $param;
    /** @var string ドメイン */
    private string $domain;

    /**
     * AccountSignUpProvider constructor.
     * @param array $param パラメータ
     */
    public function __construct($param)
    {
        $this->param = $param;
        list(, $domain) = explode('@', $param['mail']);
        $this->domain = $domain;
    }

    /** アカウント作成処理
     * @throws BindingResolutionException
     * @throws ResponseException
     */
    public function generate(): void
    {
        // メールアドレスの重複チェック ※重複していた場合はエラーを返さずに以降の処理は行わない
        if ($this->checkDuplicateMail()) {
            return;
        }

        // フリーメールチェック
        if ($this->checkFreeMail()) {
            throw new ResponseException('free mail not signUp', ErrorCode::SIGN_UP_NOT_FREE_MAIL);
        }

        // パスワードのチェック
        if (!PasswordService::checkPasswordPattern($this->getParamVal('pass'))) {
            throw new ResponseException('password pattern failed', ErrorCode::PASSWORD_PATTERN_FAILED);
        }

        $mail = $this->getParamVal('mail');
        $signUp = TrnSignUp::findByMail($mail);

        $param = [
            'token' => $this->generateOneTimeToken(),
            'expireDate' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
            'paramJson' => $this->getParamJson(),
        ];

        if (empty($signUp)) {
            $param['mail'] = $mail;
            TrnSignUp::create($param);
        } else {
            $signUp->update($param);
        }
        // 認証メールを送信
        MailManager::sendMail(
            $mail,
            new SignUpMail(
                $this->getParamVal('store'),
                $this->getParamVal('lastName') . ' ' . $this->getParamVal('firstName'),
                $param['token'],
            ),
            Str::endsWith(
                $mail,
                '@icloud.com'
            )
        );
    }

    /**
     * フリーメールアドレスのドメインかチェック
     * @return bool
     */
    private function checkFreeMail()
    {
        $domains = explode("\n", File::get(resource_path('/mails/ignore_domains.txt')));
        return in_array(Str::lower($this->domain), $domains);
    }

    /**
     * すでに登録されているドメインかチェック
     * @return bool
     */
    private function checkDuplicateMail()
    {
        return !empty(MstAuthorized::findMail($this->getParamVal('mail')));
    }

    /**
     * パスワード設定用のワンタイムトークンを発行
     * @return string
     */
    public function generateOneTimeToken()
    {
        for ($i = 0; $i < 100; $i++) {
            $token = Str::random(128);
            if (empty(TrnSignUp::findByToken($token))) {
                return $token;
            }
        }
        throw new Exception('generateOneTimeToken error!!');
    }

    /**
     * パラメータ値を取得
     * @param string $key キー
     * @return string|null
     */
    private function getParamVal($key)
    {
        return $this->param[$key] ?? null;
    }

    /**
     * JSON化したパラメータを取得
     * @return string
     */
    private function getParamJson()
    {
        $param = $this->param;
        $param['pass'] = password_hash($this->getParamVal('pass'), PASSWORD_BCRYPT);
        unset($param['reToken']);
        return json_encode($param);
    }
}
