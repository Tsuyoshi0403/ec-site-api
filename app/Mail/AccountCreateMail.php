<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * アカウント作成メール
 */
class AccountCreateMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /** @var array */
    protected $params;

    /**
     * PasswordResetMail constructor.
     * @param array $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('アカウント作成が有りました')
            ->text('emails.accountCreate')
            ->with($this->params);
    }
}