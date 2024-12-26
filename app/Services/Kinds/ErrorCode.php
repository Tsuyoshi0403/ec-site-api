<?php

namespace App\Services\Kinds;

/**
 * エラーコード
 */
class ErrorCode
{
    const ILLEGAL_PARAM = 100004;
    const VALIDATE_ERROR_REQUEST_PARAM = 100002;
    const HAVE_NO_AUTHORITY = 100006;
    const LOGIN_FAILED = 100008;
    const PASSWORD_RESET_TOKEN_FAILED = 100010;
    const PASSWORD_PATTERN_FAILED = 100014;
    const BEFORE_STORE_JOIN_LOGIN = 100015;
    const AFTER_STORE_RETIRE_LOGIN = 100016;
    const LOGIN_FAILED_ILLEGAL_ROUTE = 100017;
    const LOGIN_FAILED_NONE_ID = 100018;
    const LOGIN_FAILED_DIFFERENT_PASS = 100019;
    const LOGIN_LOCKOUT = 100042;
    const ILLEGAL_VALUE_OBJECT_PARAM = 100051;
    const COLUMN_NOT_FOUND_ERROR = 100052;
    const SIGN_UP_NOT_FREE_MAIL = 400000;
    const UNDEFINED_ERROR = 999999;

    public static $conditions = [
        self::ILLEGAL_PARAM => 'ログイン時にユーザ情報が無い時のエラー',
        self::VALIDATE_ERROR_REQUEST_PARAM => 'リクエストパラメータのバリデーションエラー',
        self::HAVE_NO_AUTHORITY => '使用権限の無い機能を実行しようとしたときのエラー',
        self::LOGIN_FAILED => 'ID/PASSログイン時に入力されたID、パスワードが間違えている場合',
        self::PASSWORD_RESET_TOKEN_FAILED => '',
        self::PASSWORD_PATTERN_FAILED => 'パスワード形式が不正した際のエラー',
        self::BEFORE_STORE_JOIN_LOGIN => 'アカウント作成より前にログインした時のエラー',
        self::AFTER_STORE_RETIRE_LOGIN => '会員退会より後にログインした際のエラー',
        self::LOGIN_FAILED_ILLEGAL_ROUTE => '不明なログイン方法(ID/pass以外)でログインを実行された場合',
        self::LOGIN_FAILED_NONE_ID => '指定されたIDが存在しない場合',
        self::LOGIN_FAILED_DIFFERENT_PASS => '指定したパスワードが間違っている場合',
        self::LOGIN_LOCKOUT => 'ログインロックアウトが発生している時のエラー',
        self::ILLEGAL_VALUE_OBJECT_PARAM => '入力値に誤りがあり、ValueObjectで弾かれた時にエラー',
        self::COLUMN_NOT_FOUND_ERROR => '指定されたカラムが見つからない場合のエラー',
        self::SIGN_UP_NOT_FREE_MAIL => 'フリーメールでアカウント作成した際のエラー',
        self::UNDEFINED_ERROR => '想定外のエラー',
    ];
}
