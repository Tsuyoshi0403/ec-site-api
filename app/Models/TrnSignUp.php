<?php

namespace App\Models;

/**
 * App\Models\TrnSignUp
 *
 * @property int $id
 * @property string $mail メールアドレス
 * @property string $token トークン
 * @property string $expireDate 有効期限
 * @property string $paramJson パラメータJSON
 * @property bool $isDeleted 削除済みフラグ
 * @property \Illuminate\Support\Carbon $createdTime 登録日
 * @property \Illuminate\Support\Carbon $updatedTime 更新日
 * @method static BaseBuilder|TrnSignUp count(string $columns = '*')
 * @method static BaseBuilder|TrnSignUp newModelQuery()
 * @method static BaseBuilder|TrnSignUp newQuery()
 * @method static BaseBuilder|TrnSignUp query()
 * @method static BaseBuilder|TrnSignUp softDelete()
 * @method static BaseBuilder|TrnSignUp whereCompanyId($value)
 * @method static BaseBuilder|TrnSignUp whereCreatedTime($value)
 * @method static BaseBuilder|TrnSignUp whereEmployeeId($value)
 * @method static BaseBuilder|TrnSignUp whereExpireDate($value)
 * @method static BaseBuilder|TrnSignUp whereId($value)
 * @method static BaseBuilder|TrnSignUp whereIsDeleted($value)
 * @method static BaseBuilder|TrnSignUp whereMail($value)
 * @method static BaseBuilder|TrnSignUp whereParamJson($value)
 * @method static BaseBuilder|TrnSignUp whereToken($value)
 * @method static BaseBuilder|TrnSignUp whereUpdatedTime($value)
 * @mixin \Eloquent
 */
class TrnSignUp extends BaseModel
{
    /** @var string テーブル名 */
    protected $table = 'trn_sign_up';
    /** @var string プライマリキー */
    public $primaryKey = 'id';

    /**
     * トークンで検索
     * @param string $token ハッシュ
     * @return TrnSignUp|null
     */
    public static function findByToken($token)
    {
        return self::where('token', $token)->first();
    }

    /**
     * メールアドレスで検索
     * @param string $mail メールアドレス
     * @return TrnSignUp|null
     */
    public static function findByMail($mail)
    {
        return self::where('mail', $mail)->first();
    }
}
