<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ModelBase
 *
 * @property int $isDeleted
 * @property string $createdTime
 * @property string $updatedTime
 * @method static \Illuminate\Database\Eloquent\Builder|ModelBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelBase query()
 * @method static BaseBuilder|ModelBase count(string $columns = '*')
 * @method static \App\Models\BaseBuilder|ModelBase softDelete()
 * @mixin \Eloquent
 */
class ModelBase extends Model
{
    const CREATED_AT = 'createdTime';
    const UPDATED_AT = 'updatedTime';
    const DELETED_AT = 'isDeleted';
    protected $guarded = [self::CREATED_AT, self::UPDATED_AT];
}
