<?php

namespace App\Http\Controllers\Admin;

use App\CourseTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\CourseTablesDataTable;

class CourseTimeController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param CourseTable $courseTable
     * @return \Illuminate\Http\Response
     */
    public function show(CourseTable $courseTable)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CourseTable $courseTable
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseTable $courseTable)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param CourseTable $courseTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseTable $courseTable)
    {
        //TODO
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
