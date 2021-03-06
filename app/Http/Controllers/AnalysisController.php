<?php

namespace App\Http\Controllers;

use App\User;
use App\CourseTable;
use Illuminate\Http\Request;
use App\Services\AnalysisService;

class AnalysisController extends Controller
{
    /**
     * @var AnalysisService
     */
    private $analysisService;

    /**
     * AnalysisController constructor.
     * @param AnalysisService $analysisService
     */
    public function __construct(AnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    public function index()
    {
        /* @var User $user */
        $user = auth()->user();
        $courseTableIds = $this->analysisService->getAnalysisCourseTableIds();
        $courseTablesQuery = CourseTable::with('user', 'courses.periods')->whereIn('id', $courseTableIds);
        if ($user->can('courseTable.manage')) {
            $courseTables = $courseTablesQuery->get();
        } else {
            $courseTables = $courseTablesQuery
                ->where('user_id', $user->id)
                ->orWhere('public', true)
                ->get();
        }

        $myCourseTables = $user->courseTables()->whereNotIn('id', $courseTableIds)->get();

        $periodTable = [];
        foreach ($courseTables as $courseTable) {
            foreach ($courseTable->courses as $course) {
                foreach ($course->periods as $period) {
                    $weekday = $period->weekday;
                    $number = $period->number;
                    if (!isset($periodTable[$weekday][$number])) {
                        $periodTable[$weekday][$number] = 0;
                    }
                    $periodTable[$weekday][$number]++;
                }
            }
        }

        return view('analysis.index', compact(['courseTables', 'myCourseTables', 'periodTable']));
    }

    public function add(Request $request, CourseTable $courseTable)
    {
        /* @var User $user */
        $user = auth()->user();
        if ($courseTable->user_id != $user->id && !$courseTable->public && !$user->can('courseTable.manage')) {
            abort(403);
        }
        $courseTableIds = $this->analysisService->getAnalysisCourseTableIds();
        $courseTableIds[] = $courseTable->id;
        $this->analysisService->setAnalysisCourseTableIds($courseTableIds);

        return redirect()->back()->with('global', '已加入分析清單');
    }

    public function remove(Request $request, CourseTable $courseTable)
    {
        $courseTableIds = $this->analysisService->getAnalysisCourseTableIds();
        if (in_array($courseTable->id, $courseTableIds)) {
            unset($courseTableIds[array_search($courseTable->id, $courseTableIds)]);
        }
        $this->analysisService->setAnalysisCourseTableIds($courseTableIds);

        return redirect()->back()->with('global', '已從分析清單移除');
    }
}
