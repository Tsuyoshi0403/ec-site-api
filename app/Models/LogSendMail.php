<?php

namespace App\Models;

/**
 * App\Models\LogSendMail
 *
 * @property int $id
 * @property string $from FROM
 * @property string $to TO
 * @property string $subject 件名
 * @property string $body 本文
 * @property int $companyId 企業ID
 * @property int $isDeleted 削除済みフラグ
 * @property \Illuminate\Support\Carbon $createdTime 登録日
 * @property \Illuminate\Support\Carbon $updatedTime 更新日
 * @method static \App\Models\BaseBuilder|LogSendMail count(string $columns = '*')
 * @method static \App\Models\BaseBuilder|LogSendMail newModelQuery()
 * @method static \App\Models\BaseBuilder|LogSendMail newQuery()
 * @method static \App\Models\BaseBuilder|LogSendMail query()
 * @method static \App\Models\BaseBuilder|LogSendMail softDelete()
 * @method static \App\Models\BaseBuilder|LogSendMail whereBody($value)
 * @method static \App\Models\BaseBuilder|LogSendMail whereCompanyId($value)
 * @method static \App\Models\BaseBuilder|LogSendMail whereCreatedTime($value)
 * @method static \App\Models\BaseBuilder|LogSendMail whereFrom($value)
 * @method static \App\Models\BaseBuilder|LogSendMail whereId($value)
 * @method static \App\Models\BaseBuilder|LogSendMail whereIsDeleted($value)
 * @method static \App\Models\BaseBuilder|LogSendMail whereSubject($value)
 * @method static \App\Models\BaseBuilder|LogSendMail whereTo($value)
 * @method static \App\Models\BaseBuilder|LogSendMail whereUpdatedTime($value)
 * @mixin \Eloquent
 */
class LogSendMail extends BaseModel
{
    /** @var string テーブル名 */
    protected $table = 'log_send_mail';
    /** @var string プライマリキー */
    public $primaryKey = 'id';
}
