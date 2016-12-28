<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use App\DataTables\TeachersDataTable;

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
        return $dataTable->render('teacher.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return view('teacher.show', compact('teacher'));
    }
}
