<?php

namespace App\Models;

/**
 * App\Models\MstEmployee
 *
 * @property int $employeeId 社員ID
 * @property string $employeeNo 社員番号
 * @property string $name 社員名
 * @property string|null $furigana フリガナ
 * @property string $mail メールアドレス
 * @property int $officeId 事業所ID
 * @property int $affiliationId 所属ID
 * @property int|null $positionId 役職ID
 * @property int|null $gradeId 等級ID
 * @property int|null $authorityId 権限ID
 * @property int|null $systemAuthorityId システム権限ID
 * @property int $employmentTypeId 雇用区分ID
 * @property int|null $daySchWorkTime 所定労働時間（日）
 * @property int|null $weekSchWorkDays 週の所定労働日数
 * @property int $deemedOvertime みなし残業時間
 * @property int $calendarId カレンダーID
 * @property int $status 顧客ステータス
 * @property string $lastAccessTime 最終APIアクセス日時
 * @property string $lastWarnDate 最終警告日
 * @property string $confirmServiceTermsVersion 確認済み利用規約バージョン
 * @property string $confirmPrivacyPolicyVersion 確認済みプライバシーポリシーバージョン
 * @property int|null $agentId
 * @property int $companyId 企業ID
 * @property bool $isDeleted 削除済みフラグ
 * @property \Illuminate\Support\Carbon $createdTime 登録日
 * @property \Illuminate\Support\Carbon $updatedTime 更新日
 * @method static ShardBuilder|MstEmployee count(string $columns = '*')
 * @method static ShardBuilder|MstEmployee newModelQuery()
 * @method static ShardBuilder|MstEmployee newQuery()
 * @method static ShardBuilder|MstEmployee query()
 * @method static ShardBuilder|MstEmployee setQueryConnection($connection)
 * @method static ShardBuilder|MstEmployee softDelete()
 * @method static ShardBuilder|MstEmployee whereAffiliationId($value)
 * @method static ShardBuilder|MstEmployee whereAuthorityId($value)
 * @method static ShardBuilder|MstEmployee whereCompanyId($value)
 * @method static ShardBuilder|MstEmployee whereCreatedTime($value)
 * @method static ShardBuilder|MstEmployee whereDaySchWorkTime($value)
 * @method static ShardBuilder|MstEmployee whereDeemedOvertime($value)
 * @method static ShardBuilder|MstEmployee whereEmployeeId($value)
 * @method static ShardBuilder|MstEmployee whereEmployeeNo($value)
 * @method static ShardBuilder|MstEmployee whereEmploymentTypeId($value)
 * @method static ShardBuilder|MstEmployee whereFurigana($value)
 * @method static ShardBuilder|MstEmployee whereGradeId($value)
 * @method static ShardBuilder|MstEmployee whereIsDeleted($value)
 * @method static ShardBuilder|MstEmployee whereLastAccessTime($value)
 * @method static ShardBuilder|MstEmployee whereLastWarnDate($value)
 * @method static ShardBuilder|MstEmployee whereMail($value)
 * @method static ShardBuilder|MstEmployee whereName($value)
 * @method static ShardBuilder|MstEmployee whereOfficeId($value)
 * @method static ShardBuilder|MstEmployee wherePositionId($value)
 * @method static ShardBuilder|MstEmployee whereCalendarId($value)
 * @method static ShardBuilder|MstEmployee whereStatus($value)
 * @method static ShardBuilder|MstEmployee whereSystemAuthorityId($value)
 * @method static ShardBuilder|MstEmployee whereUpdatedTime($value)
 * @method static ShardBuilder|MstEmployee whereWeekSchWorkDays($value)
 * @method static \Database\Factories\MstEmployeeFactory factory($count = null, $state = [])
 * @method static \App\Models\ShardBuilder|MstEmployee whereConfirmPrivacyPolicyVersion($value)
 * @method static \App\Models\ShardBuilder|MstEmployee whereConfirmServiceTermsVersion($value)
 * @mixin \Eloquent
 */
class MstCustomer extends ModelBase
{
    /** @var string テーブル名 */
    protected $table = 'mst_customer';
    /** @var string プライマリキー */
    public $primaryKey = 'customerId';

    /**
     * 顧客情報検索
     * @param int $customerId 顧客ID
     * @return MstCustomer
     */
    public static function findCustomer($customerId)
    {
        return MstCustomer::where('customerId', $customerId)->first();
    }
}
