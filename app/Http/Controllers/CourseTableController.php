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
            'name'  => $request->get('name'),
            'order' => CourseTable::where('user_id', $user->id)->max('order') + 1 ?: 0,
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

    public function data()
    {
        $courseTables = CourseTable::orderBy('order')->orderBy('id')->get();

        return response()->json($courseTables);
    }

    public function sort(Request $request)
    {
        $idList = $request->get('idList');
        $counter = 1;
        foreach ($idList as $id) {
            $courseTable = CourseTable::find($id);
            if (!$courseTable) {
                continue;
            }
            $courseTable->update([
                'order' => $counter,
            ]);
            $counter++;
        }
        //回傳結果
        $json = [
            'success' => true,
            'idList'  => $idList,
        ];

        return response()->json($json);
    }
}
