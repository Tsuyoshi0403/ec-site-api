<?php

use App\Services\Kinds\ErrorCode;

return [
    ErrorCode::VALIDATE_ERROR_REQUEST_PARAM => '予期せぬリクエストデータのため、正常に処理することができません。',
    ErrorCode::ILLEGAL_PARAM => '予期せぬパラメータのため、正常に処理することができません。',
    ErrorCode::HAVE_NO_AUTHORITY => '対象機能のアクセス権限がないため、実行できません。',
    ErrorCode::LOGIN_FAILED => 'ログインに失敗しました。',
    ErrorCode::PASSWORD_RESET_TOKEN_FAILED => 'パスワード再設定の期限が切れているため設定出来ませんでした。',
    ErrorCode::PASSWORD_PATTERN_FAILED => 'パスワードは、英字/数字/記号を2種類以上含む8文字以上32文字以下で設定してください。',
    ErrorCode::LOGIN_FAILED_ILLEGAL_ROUTE => 'ログインに失敗しました。',
    ErrorCode::LOGIN_FAILED_NONE_ID => 'IDが見つからないかパスワードが一致しないため、ログインできません。',
    ErrorCode::LOGIN_FAILED_DIFFERENT_PASS => 'IDが見つからないかパスワードが一致しないため、ログインできません。',
    ErrorCode::LOGIN_LOCKOUT => 'セキュリティの問題により一時的にアクセスが制限されています。\nしばらく時間を置いてから再度お試しください。',
    ErrorCode::ILLEGAL_VALUE_OBJECT_PARAM => ':nameの値に誤りがあります。選択肢または入力値を確認してください。',
    ErrorCode::UNDEFINED_ERROR => '予期せぬエラーが発生しました。',
];