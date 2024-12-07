<?php

namespace App\Models;

use Illuminate\Support\Carbon;

/**
 * App\Models\TrnLoginFailed
 *
 * @property int $id ID
 * @property string $mail メールアドレス
 * @property int $count 連続失敗回数
 * @property bool $isDeleted 削除済みフラグ
 * @property Carbon $createdTime 登録日
 * @property Carbon $updatedTime 更新日
 * @method static BaseBuilder|TrnLoginFailed count(string $columns = '*')
 * @method static BaseBuilder|TrnLoginFailed newModelQuery()
 * @method static BaseBuilder|TrnLoginFailed newQuery()
 * @method static BaseBuilder|TrnLoginFailed query()
 * @method static BaseBuilder|TrnLoginFailed softDelete()
 * @method static BaseBuilder|TrnLoginFailed whereCount($value)
 * @method static BaseBuilder|TrnLoginFailed whereCreatedTime($value)
 * @method static BaseBuilder|TrnLoginFailed whereId($value)
 * @method static BaseBuilder|TrnLoginFailed whereIsDeleted($value)
 * @method static BaseBuilder|TrnLoginFailed whereMail($value)
 * @method static BaseBuilder|TrnLoginFailed whereUpdatedTime($value)
 * @mixin \Eloquent
 */
class TrnLoginFailed extends BaseModel
{

    /** @var string テーブル名 */
    protected $table = 'trn_login_failed';
    /** @var string プライマリキー */
    public $primaryKey = 'id';

    /**
     * メールアドレスで検索
     * @param $mail
     * @return self|null
     */
    public static function findByMail($mail)
    {
        return self::where('mail', $mail)->first();
    }

    /**
     * 回数を更新
     * @param $count
     * @return bool
     */
    public function updateLoginFailed($count)
    {
        return $this->update(compact('count'));
    }
}
