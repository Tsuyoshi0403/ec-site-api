<?php

namespace App\Exceptions;

use App\Jobs\ErrorLogJob;
use App\Services\Kinds\ErrorCode;
use App\Services\MessageService;
use Exception;
use Illuminate\Support\Facades\Log;
use Packages\App\ValueObject\_Common\IValueObject;

class ValidationFailedException extends Exception
{
    private IValueObject $object;

    /**
     * @param IValueObject $object
     */
    public function __construct($object)
    {
        parent::__construct($object::class . ' validation failed.', ErrorCode::ILLEGAL_VALUE_OBJECT_PARAM);
        $this->object = $object;
    }

    public function report()
    {
        $logContext = ResponseException::makeLogContext($this);
        $logContext['class'] = $this->object::class;
        $logContext['value'] = $this->object->getValue();
        Log::error($this->getMessage(), $logContext);
        ErrorLogJob::dispatch([
            'customerId' => $logContext['customerId'],
            'type' => $logContext['url'],
            'code' => $this->getCode(),
            'body' => $this->getMessage() . "\n" . (empty($logContext['request']) ? '' : 'request : ' . json_encode($logContext['request'])) . "\n" . $this->getTraceAsString(),
        ]);
    }

    /**
     * ポップアップ情報取得
     * @return array
     */
    public function getErrorResponse()
    {
        $result = [];
        $message = 'code:[' . $this->getCode() . ']\n' . MessageService::getValueObjectFailedMessage($this->object::class);

        $result['error'] = [
            'code' => $this->getCode(),
            'message' => $message,
        ];
        // 本番環境ではトレースは要らない
        if (env('APP_ENV') != 'prd') {
            $result['error']['stackMessage'] = $this->getMessage();
            $result['error']['stackTrace'] = $this->getTraceAsString();
        }
        return $result;
    }
}
