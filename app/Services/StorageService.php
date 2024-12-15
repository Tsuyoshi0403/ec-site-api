<?php

namespace App\Services;

use Illuminate\Contracts\Support\Arrayable;

class StorageService implements Arrayable
{
    /** @var array ストレージ */
    private $storage;

    /**
     * StorageService constructor.
     */
    public function __construct()
    {
        $this->storage = [];
    }

    /**
     * 配列に変換
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->storage as $key => $value) {
            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }
            $array[$key] = $value;
        }
        return $array;
    }

    /**
     * 指定キーが存在するかどうか
     * @param string $key
     * @return bool
     */
    public function exists($key)
    {
        return isset($this->storage[$key]);
    }

    /**
     * 値を置き換え
     * @param string $key
     * @param mixed $value
     */
    public function put($key, $value)
    {
        $this->storage[$key] = $value;
    }

    /**
     * 値がなければ設定
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function add($key, $value)
    {
        $isAdd = false;
        if (!self::exists($key)) {
            self::put($key, $value);
            $isAdd = true;
        }
        return $isAdd;
    }

    /**
     * 値を取得
     * @param string $key
     * @param mixed $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->storage[$key] ?? $default;
    }

    /**
     * 取得時に値が存在しなければ設定する
     * @param string $key
     * @param mixed|callable $value
     * @return mixed|null
     */
    public function remember($key, $value)
    {
        if (self::exists($key)) {
            $result = self::get($key);
        } else {
            if (is_callable($value)) {
                $result = $value();
            } else {
                $result = $value;
            }
            self::put($key, $result);
        }
        return $result;
    }

    /**
     * 値を削除
     * @param string $key
     */
    public function forget($key)
    {
        $this->storage[$key] = null;
    }

    /**
     * インクリメント
     * @param string $key
     * @param int $value
     * @return int
     */
    public function increment($key, $value = 1)
    {
        $this->storage[$key] = ($this->storage[$key] ?? 0) + $value;
        return $this->storage[$key];
    }

    /**
     * デクリメント
     * @param string $key
     * @param int $value
     * @return int
     */
    public function decrement($key, $value = 1)
    {
        $this->storage[$key] = ($this->storage[$key] ?? 0) - $value;
        return $this->storage[$key];
    }

    /**
     * 保存されているキーをすべて取得
     * @return array
     */
    public function keys()
    {
        return array_keys($this->storage);
    }

    /**
     * フラッシュ
     */
    public function flash()
    {
        $this->storage = [];
    }
}
