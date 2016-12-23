<?php

namespace App\DataTables\Admin;

use App\Course;
use Yajra\Datatables\Services\DataTable;

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
        $query = Course::query();

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
            'id'       => ['title' => '#'],
            'year'     => ['title' => '學年度'],
            'semester' => ['title' => '學期'],
            'name'     => ['title' => '課程名稱'],
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
