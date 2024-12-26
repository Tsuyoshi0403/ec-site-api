<?php

namespace App\Services\Providers;

use App\Exceptions\ResponseException;
use App\Mail\AccountCreateMail;
use App\Models\MstAuthorized;
use App\Models\MstCustomer;
use App\Models\MstStore;
use App\Models\TrnLogin;
use App\Models\TrnSignUp;
use App\Services\Kinds\ErrorCode;
use App\Services\Kinds\LoginKind;
use App\Services\Managers\MailManager;
use App\Services\Managers\UserManager;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class AccountVerifyProvider
 */
class AccountVerifyProvider
{
    /** @var string 店舗番号のプレフィックス */
    const STORE_NO_PREFIX = 'k';
    /** @var string トークン */
    private string $token;
    /** @var string[] パラメータ */
    private $param;
    /** @var string ドメイン */
    private $domain;
    /** @var int 店舗ID */
    private $storeId;
    /** @var int 顧客ID */
    private $customerId;

    /**
     * AccountVerifyProvider constructor.
     *
     * @param string $token トークン
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * アカウント作成処理
     *
     * @param bool $disableReCaptcha reCaptcha非実行フラグ
     *
     * @return bool
     *
     * @throws ResponseException
     * @throws BindingResolutionException
     */
    public function generate(): bool
    {
        // トークンチェック
        $signUp = TrnSignUp::findByToken($this->token);
        if (empty($signUp)) {
            return false;
        }
        $this->param = json_decode($signUp->paramJson, true);
        list(, $domain) = explode('@', $signUp->mail);
        $this->domain = $domain;

        // TODO 時間がある時にトランザクション処理を追加する
        if (!$signUp->delete()) {
            throw new ResponseException('delete error', ErrorCode::UNDEFINED_ERROR);
        }
        
        // 初期データ登録
        self::registerInitData();
        
        return true;
    }

    /**
     * 初期データを登録
     */
    private function registerInitData()
    {
        $store = MstStore::create([
            'storeNo' => self::generateStoreNo(),
            'name' => $this->getParamVal('store'),
            'domain' => $this->domain,
            'phoneNo' => str_replace('-', '', $this->getParamVal('phoneNo', '')),
        ]);
        $this->storeId = $store->storeId;
        $authorized = MstAuthorized::create([
            'mail' => $this->getParamVal('mail'),
            'storeId' => $store->storeId,
        ]);
        UserManager::setAuth($authorized);
        $this->customerId = $authorized->customerId;
        $this->createCustomer();

        // アカウント作成完了通知メールを送信
        MailManager::sendMail(MailManager::INFO_MAIL_ADDRESS, new AccountCreateMail([...$this->param, 'createdTime' => date('Y-m-d H:i')]));
    }

    /**
     * 店舗番号を生成
     * @return string 店舗番号
     */
    private function generateStoreNo()
    {
        for ($i = 0; $i < 100; $i++) {
            $storeNo = sprintf('%07d', mt_rand(0, 9999999));
            if (MstStore::likeStoreNo($storeNo)->isEmpty()) {
                list($storeDomain) = explode('.', $this->domain);
                return self::STORE_NO_PREFIX . $storeDomain[0] . $storeDomain[-1] . $storeNo;
            }
        }
        throw new ResponseException('generateCompanyNo Failed', ErrorCode::UNDEFINED_ERROR);
    }

    /**
     * パラメータ値を取得
     * @param string $key キー
     * @param mixed|null $default デフォルト値
     * @return string|null
     */
    private function getParamVal($key, $default = null)
    {
        return $this->param[$key] ?? $default;
    }

    /** 顧客情報を作成 */
    private function createCustomer()
    {
        MstCustomer::create([
            'customerId' => $this->customerId,
            'customerNo' => '1',
            'name' => $this->getParamVal('lastName') . ' ' . $this->getParamVal('firstName'),
            'furigana' => '',
            'mail' => $this->getParamVal('mail'),
        ]);
        TrnLogin::create([
            'customerId' => $this->customerId,
            'loginKind' => LoginKind::PASSWORD,
            // アカウント登録時にすでにハッシュ化しているのでそのまま代入
            'value' => $this->getParamVal('pass'),
            'storeId' => $this->storeId,
        ]);
    }
}