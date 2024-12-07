<?php

namespace App\Database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrationBase extends Migration
{
    /** @var Blueprint */
    private $mTable;

    /**
     * Blueprint設定
     * @param Blueprint $table
     */
    public function setTable($table)
    {
        $this->mTable = $table;
    }

    /**
     * デフォルトカラム生成
     * @param bool $isCreateStoreId
     */
    public function defaults($isCreateStoreId = true)
    {
        if ($isCreateStoreId) {
            $this->storeId();
        }
        $this->isDeleted();
        $this->createdTime();
        $this->updatedTime();
    }

    /**
     * インデックス名を生成
     * @param array $columns カラムの配列
     * @return string
     */
    public function getIndexName($columns)
    {
        return 'idx' . $this->joinColumnName($columns);
    }

    /**
     * ユニークキー名を生成
     * @param array $columns カラムの配列
     * @return string
     */
    public function getUniqueKeyName($columns)
    {
        return 'uq' . $this->joinColumnName($columns);
    }

    /**
     * プライマリーキー名を生成
     * @param array $columns カラムの配列
     * @return string
     */
    public function getPrimaryKeyName($columns)
    {
        return 'pr' . $this->joinColumnName($columns);
    }

    /**
     * カラム名を結合
     * @param array $columns カラムの配列
     * @return string
     */
    private function joinColumnName($columns)
    {
        // 配列のインデックスを振りなおす
        $columns = array_values($columns);
        // 最後のインデックスを取得
        $lastKey = array_key_last($columns);
        $name = '';
        foreach ($columns as $key => $column) {
            $name .= ucfirst($column);
            if ($key !== $lastKey) {
                $name .= 'And';
            }
        }
        return $name;
    }

    /**
     * インデックス生成
     * @param array $columns カラムの配列
     * @param string|null $algorithm アルゴリズム
     */
    public function index($columns, $algorithm = null)
    {
        $this->mTable->index($columns, $this->getIndexName($columns), $algorithm);
    }

    /**
     * ユニークキー生成
     * @param array $columns カラムの配列
     * @param string|null $algorithm アルゴリズム
     */
    public function uniqueKey($columns, $algorithm = null)
    {
        $this->mTable->unique($columns, $this->getUniqueKeyName($columns), $algorithm);
    }

    /**
     * プライマリーキー生成
     * @param array $columns カラムの配列
     * @param string|null $algorithm アルゴリズム
     */
    public function primaryKey($columns, $algorithm = null)
    {
        $this->mTable->primary($columns, $this->getPrimaryKeyName($columns), $algorithm);
    }

    /**
     * 削除済みフラグ生成
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function isDeleted()
    {
        return $this->mTable->unsignedTinyInteger('isDeleted')->default(0)->comment('削除済みフラグ');
    }

    /**
     * 登録日生成
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function createdTime()
    {
        return $this->mTable->dateTime('createdTime')->default('1970-01-01 00:00:00')->comment('登録日');
    }

    /**
     * 更新日生成
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function updatedTime()
    {
        return $this->mTable->dateTime('updatedTime')->default('1970-01-01 00:00:00')->comment('更新日');
    }

    /**
     * 店舗ID生成
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function storeId()
    {
        return $this->mTable->unsignedBigInteger('storeId')->comment('店舗ID');
    }

    /**
     * ソート番号生成
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function sortNo()
    {
        return $this->mTable->unsignedInteger('sortNo')->comment('ソート番号');
    }

    /**
     * 顧客ID生成
     */
    public function customerId()
    {
        $this->mTable->unsignedBigInteger('customerId')->comment('顧客ID');
    }
}
