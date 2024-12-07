<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\MstAuthorized
 *
 * @property int $customerId 顧客ID
 * @property string $mail メールアドレス
 * @property int $storeId 店舗ID
 * @property bool $isDeleted 削除済みフラグ
 * @property Carbon $createdTime 登録日
 * @property Carbon $updatedTime 更新日
 * @property DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property int|null $notifications_count
 * @property Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property int|null $tokens_count
 * @method static BaseBuilder|MstAuthorized count(string $columns = '*')
 * @method static BaseBuilder|MstAuthorized newModelQuery()
 * @method static BaseBuilder|MstAuthorized newQuery()
 * @method static BaseBuilder|MstAuthorized query()
 * @method static BaseBuilder|MstAuthorized softDelete()
 * @method static BaseBuilder|MstAuthorized whereStoreId($value)
 * @method static BaseBuilder|MstAuthorized whereCreatedTime($value)
 * @method static BaseBuilder|MstAuthorized whereCustomerId($value)
 * @method static BaseBuilder|MstAuthorized whereIsDeleted($value)
 * @method static BaseBuilder|MstAuthorized whereMail($value)
 * @method static BaseBuilder|MstAuthorized whereUpdatedTime($value)
 * @method static \Database\Factories\MstAuthorizedFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class MstAuthorized extends Auth implements JWTSubject
{
    use Notifiable;
    use HasApiTokens;

    /** @var string テーブル名 */
    protected $table = 'mst_authorized';
    /** @var string プライマリキー */
    public $primaryKey = 'customerId';

    const CREATED_AT = 'createdTime';
    const UPDATED_AT = 'updatedTime';
    protected $guarded = [];
    private $agentId;

    public function delete()
    {
        return parent::delete();
    }

    /**
     * JWT の sub に含める値。主キーを使う
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT のクレームに追加する値。今回は特になし
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 認証情報取得
     * @param string $mail メールアドレス
     * @return MstAuthorized|Builder|Model
     */
    public static function findMail($mail)
    {
        return self::where('mail', $mail)->first();
    }
}
