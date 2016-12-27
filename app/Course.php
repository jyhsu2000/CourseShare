<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Course
 *
 * @property string $id 課程編號
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseTable[] $courseTables
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Teacher[] $teachers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Period[] $periods
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rate[] $rates
 * @property-read string $teacher_names
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
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'id',
        'year', //學年
        'semester', //學期
        'scr_period', //上課時間/上課教室/授課教師
        'sub_name', //科目名稱
        'scj_scr_mso', //必選修
        'scr_acptcnt', //實收名額
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

    public function courseTables()
    {
        return $this->belongsToMany(CourseTable::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function periods()
    {
        return $this->belongsToMany(Period::class)->withPivot('location');
    }

    public function rates()
    {
        return $this->morphMany(Rate::class, 'rateable');
    }

    public function getTeacherNamesAttribute()
    {
        $teacherNameArray = $this->teachers->pluck('name')->toArray();
        $teacherName = implode('、', $teacherNameArray);

        return $teacherName;
    }

    public static function getYearRange()
    {
        $startYear = 90;
        $endYear = Carbon::now()->year - 1911;
        $range = range($startYear, $endYear);
        $array = array_combine($range, $range);

        return $array;
    }

    public function parse()
    {
        //上課時間/上課教室/授課教師
        $scr_period = $this->scr_period;
        $terms = preg_split('/\\s+/', $scr_period);
        $termCount = count($terms);
        $hasTeacher = $termCount % 2 == 1;
        $periodIds = [];
        //錯誤標記（若發生錯誤，強制清除節次資料與教師資料）
        $errorFlag = false;
        for ($i = 0; $i < $termCount / 2; $i += 2) {
            try {
                $location = $terms[$i + 1];
                $weekdayAndPeriods = $terms[$i];
                $matchCount = preg_match('/\((.*)\)(\d+(?:-\d+)?)/', $weekdayAndPeriods, $matches);
                if ($matchCount) {
                    //星期幾
                    $weekday = $matches[1];
                    $weekdayNumber = array_search($weekday, ['日', '一', '二', '三', '四', '五', '六']);
                    //第幾節
                    $periods = $matches[2];
                    if (str_contains($periods, '-')) {
                        $periodRange = preg_split('/\-/', $periods);
                        $startPeriod = (int) $periodRange[0];
                        $endPeriod = (int) $periodRange[1];
                        $periodNumbers = range($startPeriod, $endPeriod);
                    } else {
                        $periodNumbers = [(int) $periods];
                    }
                    foreach ($periodNumbers as $periodNumber) {
                        /* @var Period $period */
                        $period = Period::firstOrCreate(['weekday' => $weekdayNumber, 'number' => $periodNumber]);
                        $periodIds[$period->id] = ['location' => $location];
                    }
                }
            } catch (\Exception $exception) {
                //發生錯誤時，標記錯誤，清除節次資料，並中斷剖析
                $errorFlag = true;
                $periodIds = [];
                break;
            }
        }
        $this->periods()->sync($periodIds);
        $teacherIds = [];
        //老師（若已發生錯誤則不剖析）
        if ($hasTeacher && !$errorFlag) {
            try {
                $teacherNameString = $terms[$termCount - 1];
                $teacherNames = explode(',', $teacherNameString);
                foreach ($teacherNames as $teacherName) {
                    /* @var Teacher $teacher */
                    $teacher = Teacher::firstOrCreate(['name' => $teacherName]);
                    $teacherIds[] = $teacher->id;
                }
            } catch (\Exception $exception) {
                //發生錯誤時，清除教師資料
                $teacherIds = [];
            }
        }
        $this->teachers()->sync($teacherIds);

        return $this->scr_period;
    }
}
