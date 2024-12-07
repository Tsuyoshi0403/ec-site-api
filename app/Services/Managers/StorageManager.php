<?php

namespace App\Services\Managers;

use App\Services\StorageService;

class StorageManager
{
    /** @var array|StorageService[] */
    private static $storages = [];

    /**
     * 全てのストレージを削除
     */
    public static function flash()
    {
        self::$storages = [];
    }

    /**
     * ストレージ取得
     * @param string $class
     * @return StorageService
     */
    public static function getStorage($class)
    {
        if (empty(self::$storages[$class])) {
            self::$storages[$class] = new StorageService();
        }
        return self::$storages[$class];
    }

    /**
     * 保存キーをすべて取得
     * @return array
     */
    public static function keys()
    {
        $keys = [];
        foreach (self::$storages as $class => $storage) {
            $keys[$class] = $storage->keys();
        }
        return $keys;
    }

    /**
     * 保存情報をすべて取得
     * @return array
     */
    public static function contents()
    {
        $values = [];
        foreach (self::$storages as $class => $storage) {
            $values[$class] = $storage->toArray();
        }
        return $values;
    }

    /**
     * ストレージ削除
     * @param string $class
     */
    public static function flashStorage($class)
    {
        self::$storages[$class] = null;
    }
}
