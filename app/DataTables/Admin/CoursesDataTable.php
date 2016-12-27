<?php

namespace App\DataTables\Admin;

use App\Course;
use App\Period;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder;

class CoursesDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'admin.course.datatables.action')
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        /* @var Builder $query */
        $query = Course::whereNull('user_id');
        //學年
        $year = \Request::get('year');
        if ($year) {
            $query->where('year', $year);
        }
        //學期
        $semester = \Request::get('semester');
        if ($semester) {
            $query->where('semester', $semester);
        }
        //星期幾
        $weekday = \Request::get('weekday');
        //第幾節
        $periodNumber = \Request::get('periodNumber');
        if ($weekday || $weekday === '0' || $periodNumber) {
            $periodQuery = Period::query();
            if ($weekday || $weekday === '0') {
                $periodQuery->where('weekday', $weekday);
            }
            if ($periodNumber) {
                $periodQuery->where('number', $periodNumber);
            }
            $periods = $periodQuery->get();
            $courseIds = [];
            foreach ($periods as $period) {
                $checkCourseIds = $period->courses->pluck('id')->toArray();
                $courseIds = array_unique(array_merge($courseIds, $checkCourseIds));
            }
            $query->whereIn('id', $courseIds);
        }

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->ajax('')
            ->addAction(['title' => '操作'])
            ->parameters($this->getBuilderParameters())
            ->parameters([
                'order'      => [[0, 'asc']],
                'pageLength' => 50,
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
//            'id'          => ['title' => '#'],
//            'year'        => ['title' => '學年度'],
//            'semester'    => ['title' => '學期'],
            'scr_selcode' => ['title' => '選課代號'],
            'sub_name'    => ['title' => '科目名稱'],
            'scr_credit'  => ['title' => '學分'],
            'scj_scr_mso' => ['title' => '必選修'],
            'scr_examid'  => ['title' => '期中考'],
            'scr_examfn'  => ['title' => '期末考'],
            'scr_exambf'  => ['title' => '提前考'],
            'cls_name'    => ['title' => '開課班級'],
            'scr_period'  => ['title' => '上課時間/上課教室/授課教師'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'courses_' . time();
    }
}
