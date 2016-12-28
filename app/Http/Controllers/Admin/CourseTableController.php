<?php

namespace App\Http\Controllers\Admin;

use App\CourseTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\CourseTablesDataTable;

class CourseTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CourseTablesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(CourseTablesDataTable $dataTable)
    {
        return $dataTable->render('admin.courseTable.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CourseTable $courseTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseTable $courseTable)
    {
        $courseTable->delete();

        return redirect()->route('admin.courseTable.index')->with('global', '已刪除課表');
    }
}
