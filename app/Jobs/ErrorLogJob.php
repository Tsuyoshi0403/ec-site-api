<?php

namespace App\Jobs;

use App\Models\LogError;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ErrorLogJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $insertData;

    /**
     * ErrorLogJob constructor.
     * @param array $insertData 登録データ
     */
    public function __construct($insertData)
    {
        $this->insertData = $insertData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        LogError::create([
            'customerId' => $this->insertData['customerId'] ?? 0,
            'type' => $this->insertData['type'] ?? '',
            'code' => $this->insertData['code'] ?? '',
            'body' => $this->insertData['body'] ?? '',
        ]);
    }
}
