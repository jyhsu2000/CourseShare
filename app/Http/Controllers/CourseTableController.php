<?php

namespace App\Http\Controllers;

use App\User;
use App\CourseTable;
use Illuminate\Http\Request;

class CourseTableController extends Controller
{
    /**
     * CourseTableController constructor.
     */
    public function __construct()
    {
        $this->middleware('owner:courseTable', ['only' => ['edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO 改用Vue，加上排序功能
        return view('courseTable.index');
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
        /** @var User $user */
        $user = auth()->user();
        $user->courseTables()->save(new CourseTable([
            'name' => $request->get('name'),
        ]));

        return redirect()->route('courseTable.index')->with('global', '已建立課表');
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

        return redirect()->route('courseTable.index')->with('global', '已刪除課表');
    }
}
