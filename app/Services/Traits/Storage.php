<?php

namespace App\Services\Traits;

use App\Services\Managers\StorageManager;

trait Storage
{
    /**
     * ストレージ取得
     * @param string|null $class
     * @return \App\Services\StorageService
     */
    protected static function getStorage($class = null)
    {
        return StorageManager::getStorage($class ?? static::class);
    }

    /**
     * ストレージ削除
     * @param string|null $class
     */
    protected static function flashStorage($class = null)
    {
        StorageManager::flashStorage($class ?? static::class);
    }
}