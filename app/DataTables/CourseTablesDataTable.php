<?php

namespace App\DataTables;

use App\CourseTable;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder;

class CourseTablesDataTable extends DataTable
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
            ->addColumn('action', 'courseTable.datatables.action')
            ->editColumn('user_id', 'courseTable.datatables.user-name')
            ->filterColumn('user_id', function ($query, $keyword) {
                /* @var Builder $query */
                $query->whereIn('user_id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('users.id')
                        ->from('users')
                        ->join('course_tables', 'users.id', '=', 'course_tables.user_id')
                        ->whereRaw('users.name LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $user = auth()->user();
        /* @var Builder $query */
        $query = CourseTable::with('user')->where(function ($query) use ($user) {
            /* @var Builder $query */
            $query->where('user_id', $user->id)
                ->orWhere('public', true);
        });

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
            'id'      => ['title' => '#'],
            'user_id' => ['title' => '擁有者'],
            'name'    => ['title' => '課表名稱'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'coursetables_' . time();
    }
}
