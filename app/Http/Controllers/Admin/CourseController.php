<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\CoursesDataTable;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CoursesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(CoursesDataTable $dataTable)
    {
        return $dataTable->render('admin.course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course.create-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: 調整欄位
        $this->validate($request, [
            'name'     => 'required|max:255',
            'year'     => 'required|integer',   //TODO: 檢查是否落在Course的yearRange
            'semester' => 'required|in:1,2',
        ]);
        $course = Course::create($request->all());

        return redirect()->route('admin.course.show', $course)->with('global', '課程已建立');
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('admin.course.create-or-edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //TODO: 調整欄位
        $this->validate($request, [
            'name'     => 'required|max:255',
            'year'     => 'required|integer',   //TODO: 檢查是否落在Course的yearRange
            'semester' => 'required|in:1,2',
        ]);
        $course->update($request->all());

        return redirect()->route('admin.course.show', $course)->with('global', '課程已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.course.index')->with('global', '課程已刪除');
    }
}
