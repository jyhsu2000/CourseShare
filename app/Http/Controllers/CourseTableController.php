<?php

namespace App\Http\Controllers;

use App\User;
use App\CourseTable;
use Illuminate\Http\Request;
use App\Services\AnalysisService;

class CourseTableController extends Controller
{
    /**
     * @var AnalysisService
     */
    private $analysisService;

    /**
     * CourseTableController constructor.
     * @param AnalysisService $analysisService
     */
    public function __construct(AnalysisService $analysisService)
    {
        $this->middleware('owner:courseTable', ['only' => ['edit', 'update', 'destroy', 'togglePublic']]);
        $this->analysisService = $analysisService;
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
        $user = auth()->user();
        if ($courseTable->user_id != $user->id && !$courseTable->public && !$user->can('courseTable.manage')) {
            abort(403);
        }
        //記錄最後訪問課表ID
        if ($courseTable->user_id == $user->id) {
            session(['lastCourseTableId_' . $user->id => $courseTable->id]);
        }
        //分析用課表清單
        $analysisCourseTableIds = $this->analysisService->getAnalysisCourseTableIds();
        $inAnalysisCourseTable = in_array($courseTable->id, $analysisCourseTableIds);

        $periodTable = [];
        foreach ($courseTable->courses as $course) {
            foreach ($course->periods as $period) {
                $weekday = $period->weekday;
                $number = $period->number;
                if (!isset($periodTable[$weekday][$number])) {
                    $periodTable[$weekday][$number] = [];
                }
                $periodCourseItem = new \stdClass();
                $periodCourseItem->id = $course->id;
                $periodCourseItem->name = $course->sub_name;
                $periodCourseItem->teacher = $course->teacher_names;
                $periodCourseItem->location = $period->pivot->location;
                $periodTable[$weekday][$number][] = $periodCourseItem;
            }
        }

        return view('courseTable.show', compact(['courseTable', 'periodTable', 'inAnalysisCourseTable']));
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
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $courseTable->update([
            'name' => $request->get('name'),
        ]);

        return redirect()->route('courseTable.show', compact('courseTable'))->with('global', '已修改課表名稱');
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
        $user = auth()->user();
        $courseTables = CourseTable::where('user_id', $user->id)
            ->orderBy('order')->orderBy('id')->get();

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

    public function togglePublic(CourseTable $courseTable)
    {
        $courseTable->update(['public' => !$courseTable->public]);
        $message = '課表隱私設定已設定為 ' . ($courseTable->public ? '公開' : '私人');

        return redirect()->route('courseTable.show', $courseTable)->with('global', $message);
    }
}
