<?php

namespace App\Services\Kinds;

/**
 * ログイン種別
 */
class LoginKind
{
    /** @var int パスワード */
    const PASSWORD = 1;

    /**
     * 種別一覧
     */
    const KINDS = [
        self::PASSWORD,
    ];
}
