<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * サインアップメール
 */
class SignUpMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /** @var string 店舗名 */
    protected $store;
    /** @var string 名前 */
    protected $name;
    /** @var string 認証リンク */
    protected $link;

    /**
     * SignUpMail constructor.
     * @param string $store 店舗名
     * @param string $name 名前
     * @param string $token トークン
     */
    public function __construct($store, $name, $token)
    {
        $this->store = $store;
        $this->name = $name;
        $this->link = env('SIGN_UP_URL') . "/account-verify/{$token}";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('本人認証、メールアドレス確認のご案内')
            ->text('emails.signup')
            ->with([
                'store' => $this->store,
                'name' => $this->name,
                'link' => $this->link,
            ]);
    }
}