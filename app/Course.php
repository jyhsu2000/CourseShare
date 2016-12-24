<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Course
 *
 * @property int $id 課程編號
 * @property int $user_id
 * @property int $year 學年
 * @property int $semester 學期
 * @property string $scr_period 上課時間/上課教室/授課教師
 * @property int $scr_acptcnt 實收名額
 * @property string $sub_name 科目名稱
 * @property string $scj_scr_mso 必選修
 * @property int $scr_precnt 開放名額
 * @property string $scr_selcode 選課代號
 * @property int $scr_credit 學分
 * @property int $unt_ls
 * @property string $scr_dup
 * @property string $scr_remarks 備註
 * @property string $cls_name 班級
 * @property string $sub_id 課程ID
 * @property string $cls_id 班級ID
 * @property string $scr_exambf 提前考
 * @property string $scr_examid 期中考
 * @property string $scr_examfn 期末考
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseTime[] $courseTimes
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSemester($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrPeriod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrAcptcnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSubName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScjScrMso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrPrecnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrSelcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrCredit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereUntLs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrDup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereClsName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSubId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereClsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrExambf($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrExamid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereScrExamfn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    protected $fillable = [
        'user_id',
        'id',
        'year',
        'semester',
        'year', //學年
        'semester', //學期
        'scr_period', //上課時間/上課教室/授課教師
        'scr_acptcnt', //實收名額
        'sub_name', //科目名稱
        'scj_scr_mso', //必選修
        'scr_precnt', //開放名額
        'scr_selcode', //選課代號
        'scr_credit', //學分
        'unt_ls',
        'scr_dup',
        'scr_remarks', //備註
        'cls_name', //班級
        'sub_id', //課程ID
        'cls_id', //班級ID
        'scr_exambf', //提前考
        'scr_examid', //期中考
        'scr_examfn', //期末考
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseTimes()
    {
        return $this->hasMany(CourseTime::class);
    }

    public static function getYearRange()
    {
        $startYear = 90;
        $endYear = Carbon::now()->year - 1911;
        $range = range($startYear, $endYear);
        $array = array_combine($range, $range);

        return $array;
    }
}
