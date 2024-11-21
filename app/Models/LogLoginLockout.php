<?php

namespace App\Models;

use App\Services\Utilities\AccessClientUtil;

/**
 * App\Models\LogLoginLockout
 *
 * @property int $id ID
 * @property string $mail メールアドレス
 * @property string $count 連続失敗回数
 * @property string $api ロックアウト時API
 * @property string $lockoutTime ロックアウト日時
 * @property string $ip IPアドレス
 * @property string $userAgent ユーザエージェント
 * @property string $other ユーザエージェント
 * @property bool $isDeleted 削除済みフラグ
 * @property \Illuminate\Support\Carbon $createdTime 登録日
 * @property \Illuminate\Support\Carbon $updatedTime 更新日
 * @method static BaseBuilder|LogLoginLockout count(string $columns = '*')
 * @method static BaseBuilder|LogLoginLockout newModelQuery()
 * @method static BaseBuilder|LogLoginLockout newQuery()
 * @method static BaseBuilder|LogLoginLockout query()
 * @method static BaseBuilder|LogLoginLockout softDelete()
 * @method static BaseBuilder|LogLoginLockout whereApi($value)
 * @method static BaseBuilder|LogLoginLockout whereCount($value)
 * @method static BaseBuilder|LogLoginLockout whereCreatedTime($value)
 * @method static BaseBuilder|LogLoginLockout whereId($value)
 * @method static BaseBuilder|LogLoginLockout whereIp($value)
 * @method static BaseBuilder|LogLoginLockout whereIsDeleted($value)
 * @method static BaseBuilder|LogLoginLockout whereLockoutTime($value)
 * @method static BaseBuilder|LogLoginLockout whereMail($value)
 * @method static BaseBuilder|LogLoginLockout whereOther($value)
 * @method static BaseBuilder|LogLoginLockout whereUpdatedTime($value)
 * @method static BaseBuilder|LogLoginLockout whereUserAgent($value)
 * @mixin \Eloquent
 */
class LogLoginLockout extends BaseModel
{
    /** @var string テーブル名 */
    protected $table = 'log_login_lockout';
    /** @var string プライマリキー */
    public $primaryKey = 'id';

    /**
     * メールアドレスで検索
     * @param $mail
     * @return self|null
     */
    public static function findByMail($mail)
    {
        return self::where('mail', $mail)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * ロックアウト情報生成
     * @param string $mail メールアドレス
     * @param int $count 連続失敗回数
     * @param string $api API
     * @param string $other その他情報
     * @return LogLoginLockout|\Illuminate\Database\Eloquent\Model
     */
    public static function createLockout($mail, $count, $api, $other = '')
    {
        $lockoutTime = date('Y-m-d H:i:s');
        $ip = AccessClientUtil::getIpAddress();
        $userAgent = AccessClientUtil::getHeaderKey('User-Agent');
        return self::create(compact('mail', 'count', 'api', 'lockoutTime', 'ip', 'userAgent', 'other'));
    }
}
