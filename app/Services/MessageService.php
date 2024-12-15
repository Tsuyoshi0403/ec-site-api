<?php

namespace App\Services;

use App\Services\Kinds\ErrorCode;
use Illuminate\Support\Facades\Lang;

class MessageService
{
    /** @var string エラーメッセージ格納先ファイル名 */
    private const ERROR_FILE_NAME = 'errors';
    /** @var string ValueObjectの名前格納先ファイル名 */
    private const VALUE_OBJECT_NAMES = 'valueObjectNames';

    /**
     * メッセージ取得
     * @param $fileName
     * @param $code
     * @param array $replace
     * @return string
     */
    public static function getMessage($fileName, $code, $replace = [])
    {
        $key = $fileName . '.' . $code;
        $message = Lang::get($key, $replace);
        
        return $message !== $key ? $message : null;
    }

    /**
     * エラーメッセージ取得
     * @param int $code
     * @return string
     */
    public static function getErrorMessage($code)
    {
        $message = self::getMessage(self::ERROR_FILE_NAME, $code);
        // 未定義のエラーコードの場合、汎用エラーメッセージを返す
        if (is_null($message)) {
            $message = MessageService::getErrorMessage(ErrorCode::UNDEFINED_ERROR);
        }
        return $message;
    }

    /**
     * ValueObjectの値エラーメッセージ取得
     * @param string $class
     * @return string|null
     */
    public static function getValueObjectFailedMessage($class)
    {
        $name = self::getMessage(self::VALUE_OBJECT_NAMES, $class) ?? '';
        return self::getMessage(
            self::ERROR_FILE_NAME,
            ErrorCode::ILLEGAL_VALUE_OBJECT_PARAM,
            ['name' => $name]
        );
    }
}
