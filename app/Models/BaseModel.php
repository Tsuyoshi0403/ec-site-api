<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @property int $isDeleted
 * @property string $createdTime
 * @property string $updatedTime
 * @method static \App\Models\BaseBuilder|BaseModel softDelete()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    const CREATED_AT = 'createdTime';
    const UPDATED_AT = 'updatedTime';
    const DELETED_AT = 'isDeleted';
    protected $guarded = [self::CREATED_AT, self::UPDATED_AT];

    protected $hidden = [
        'id',
        'customerId',
        'storeId',
        'createdTime',
        'updatedTime',
        'isDeleted',
    ];

    /**
     * 日付カラムのシリアライズ方法
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i');
    }

    /**
     * ソフトデリート
     * @return bool
     */
    public function softDelete()
    {
        return $this->update([self::DELETED_AT => 1]);
    }
}
