<?php

namespace App\Http\Controllers\Admin;

use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\TeachersDataTable;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TeachersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(TeachersDataTable $dataTable)
    {
        return $dataTable->render('admin.teacher.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $teacher = Teacher::create($request->all());

        return redirect()->route('admin.teacher.index')->with('global', '教師已建立');
    }

    /**
     * Display the specified resource.
     *
     * @param Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return view('admin.teacher.show', compact('teacher'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('admin.teacher.index')->with('global', '教師除');
    }
}
