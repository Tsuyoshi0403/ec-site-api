<?php

namespace App\Models;

/**
 * App\Models\TrnLogin
 *
 * @property int $id ID
 * @property int $customerId 顧客ID
 * @property bool $loginKind ログイン種別
 * @property string|null $value ログイン情報
 * @property int $companyId 企業ID
 * @property bool $isDeleted 削除済みフラグ
 * @property \Illuminate\Support\Carbon $createdTime 登録日
 * @property \Illuminate\Support\Carbon $updatedTime 更新日
 * @method static ShardBuilder|TrnLogin count(string $columns = '*')
 * @method static ShardBuilder|TrnLogin newModelQuery()
 * @method static ShardBuilder|TrnLogin newQuery()
 * @method static ShardBuilder|TrnLogin query()
 * @method static ShardBuilder|TrnLogin setQueryConnection($connection)
 * @method static ShardBuilder|TrnLogin softDelete()
 * @method static ShardBuilder|TrnLogin whereCompanyId($value)
 * @method static ShardBuilder|TrnLogin whereCreatedTime($value)
 * @method static ShardBuilder|TrnLogin whereCustomerIdId($value)
 * @method static ShardBuilder|TrnLogin whereId($value)
 * @method static ShardBuilder|TrnLogin whereIsDeleted($value)
 * @method static ShardBuilder|TrnLogin whereLoginKind($value)
 * @method static ShardBuilder|TrnLogin whereUpdatedTime($value)
 * @method static ShardBuilder|TrnLogin whereValue($value)
 * @mixin \Eloquent
 */
class TrnLogin extends BaseModel
{
    /** @var string テーブル名 */
    protected $table = 'trn_login';
    /** @var string プライマリキー */
    public $primaryKey = 'id';

    /**
     * 社員IDとログイン種別で検索
     * @param int $customerId 顧客ID
     * @param mixed $loginKind
     * @return TrnLogin
     */
    public static function findByCustomerIdAndKind($customerId, $loginKind)
    {
        return self::where('customerId', $customerId)
            ->where('loginKind', $loginKind)
            ->first();
    }
}
