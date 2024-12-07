<?php

namespace App\Models;

/**
 * App\Models\LogError
 *
 * @property int $id
 * @property int $employeeId 社員ID
 * @property string $type エラータイプ
 * @property string $code エラーコード
 * @property string $body エラー内容
 * @property bool $isDeleted 削除済みフラグ
 * @property \Illuminate\Support\Carbon $createdTime 登録日
 * @property \Illuminate\Support\Carbon $updatedTime 更新日
 * @method static BaseBuilder|LogError count(string $columns = '*')
 * @method static BaseBuilder|LogError newModelQuery()
 * @method static BaseBuilder|LogError newQuery()
 * @method static BaseBuilder|LogError query()
 * @method static BaseBuilder|LogError softDelete()
 * @method static BaseBuilder|LogError whereBody($value)
 * @method static BaseBuilder|LogError whereCode($value)
 * @method static BaseBuilder|LogError whereCreatedTime($value)
 * @method static BaseBuilder|LogError whereEmployeeId($value)
 * @method static BaseBuilder|LogError whereId($value)
 * @method static BaseBuilder|LogError whereIsDeleted($value)
 * @method static BaseBuilder|LogError whereType($value)
 * @method static BaseBuilder|LogError whereUpdatedTime($value)
 * @mixin \Eloquent
 */
class LogError extends BaseModel
{
    /** @var string テーブル名 */
    protected $table = 'log_error';
    /** @var string プライマリキー */
    public $primaryKey = 'id';
}
