<?php

namespace App\Models;

/**
 * App\Models\MstStore
 *
 * @property int $storeId 店舗ID
 * @property string $storeNo 店舗番号
 * @property string $name 店舗名
 * @property string $domain ドメイン
 * @property string $phoneNo 電話番号
 * @property \Illuminate\Support\Carbon $createdTime 登録日
 * @property \Illuminate\Support\Carbon $updatedTime 更新日
 * @method static BaseBuilder|MstStore count(string $columns = '*')
 * @method static BaseBuilder|MstStore newModelQuery()
 * @method static BaseBuilder|MstStore newQuery()
 * @method static BaseBuilder|MstStore query()
 * @method static BaseBuilder|MstStore softDelete()
 * @method static BaseBuilder|MstStore whereStoreId($value)
 * @method static BaseBuilder|MstStore whereStoreNo($value)
 * @method static BaseBuilder|MstStore whereCreatedTime($value)
 * @method static BaseBuilder|MstStore whereDomain($value)
 * @method static BaseBuilder|MstStore whereName($value)
 * @method static BaseBuilder|MstStore wherePhoneNo($value)
 * @method static BaseBuilder|MstStore whereUpdatedTime($value)
 * @mixin \Eloquent
 */
class MstStore extends BaseModel
{
    /** @var string テーブル名 */
    protected $table = 'mst_store';
    /** @var string プライマリキー */
    public $primaryKey = 'storeId';

    /**
     * 店舗番号を後方一致で検索
     * @param string $storeNo 店舗番号の数値部分のみ
     * @return MstStore[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function likeStoreNo($storeNo)
    {
        return self::where('storeNo', 'like', '%' . $storeNo)->get();
    }
}
