<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use App\CourseTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\DataTables\CoursesDataTable;

class CourseController extends Controller
{
    /**
     * CourseTableController constructor.
     */
    public function __construct()
    {
        $this->middleware('owner:course', ['only' => ['edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param CoursesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(CoursesDataTable $dataTable)
    {
        return $dataTable->render('course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course.create-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //FIXME: 課程ID跟他人創建課程重複時，依然會噴錯，需討論
        $this->validate($request, [
            'year'        => 'required|integer',   //TODO: 檢查是否落在Course的yearRange
            'semester'    => 'required|in:1,2',
            'id'          => ['required', 'max:255', Rule::unique(app(Course::class)->getTable())],
            'sub_name'    => 'required|max:255',
            'scr_period'  => 'max:255',
            'scj_scr_mso' => 'max:255',
            'scr_acptcnt' => 'integer|min:0',
            'scr_precnt'  => 'integer|min:0',
            'scr_selcode' => 'max:255',
            'scr_credit'  => 'integer|min:0',
            'unt_ls'      => 'integer',
            'scr_dup'     => 'max:255',
            'scr_remarks' => 'max:255',
            'cls_name'    => 'max:255',
            'sub_id'      => 'max:255',
            'cls_id'      => 'max:255',
            'scr_exambf'  => 'max:255',
            'scr_examid'  => 'max:255',
            'scr_examfn'  => 'max:255',
        ]);
        $properties = array_merge($request->all(), [
            'scr_acptcnt' => (int) $request->get('scr_acptcnt'),
            'scr_precnt'  => (int) $request->get('scr_precnt'),
            'scr_credit'  => (int) $request->get('scr_credit'),
            'unt_ls'      => (int) $request->get('unt_ls'),
        ]);
        /* @var User $user */
        $user = auth()->user();
        $course = $user->courses()->save(new Course($properties));

        return redirect()->route('course.show', $course)->with('global', '課程已建立');
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $courseTables = $course->courseTables()->where('public', true)->get();
        $classMateIds = [];
        foreach ($courseTables as $courseTable) {
            $classMateIds[] = $courseTable->user_id;
        }
        $classMateIds = array_unique($classMateIds);
        $classMates = User::whereIn('id', $classMateIds)->get();

        return view('course.show', compact(['course', 'classMates']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('course.create-or-edit', compact('course'));
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
        //FIXME: 課程ID跟他人創建課程重複時，依然會噴錯，需討論
        $this->validate($request, [
            'year'        => 'required|integer',   //TODO: 檢查是否落在Course的yearRange
            'semester'    => 'required|in:1,2',
            'id'          => ['required', 'max:255', Rule::unique(app(Course::class)->getTable())->ignore($course->id)],
            'sub_name'    => 'required|max:255',
            'scr_period'  => 'max:255',
            'scj_scr_mso' => 'max:255',
            'scr_acptcnt' => 'integer|min:0',
            'scr_precnt'  => 'integer|min:0',
            'scr_selcode' => 'max:255',
            'scr_credit'  => 'integer|min:0',
            'unt_ls'      => 'integer',
            'scr_dup'     => 'max:255',
            'scr_remarks' => 'max:255',
            'cls_name'    => 'max:255',
            'sub_id'      => 'max:255',
            'cls_id'      => 'max:255',
            'scr_exambf'  => 'max:255',
            'scr_examid'  => 'max:255',
            'scr_examfn'  => 'max:255',
        ]);
        $properties = array_merge($request->all(), [
            'scr_acptcnt' => (int) $request->get('scr_acptcnt'),
            'scr_precnt'  => (int) $request->get('scr_precnt'),
            'scr_credit'  => (int) $request->get('scr_credit'),
            'unt_ls'      => (int) $request->get('unt_ls'),
        ]);
        $course->update($properties);

        return redirect()->route('course.show', $course)->with('global', '課程已更新');
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

        return redirect()->route('course.index')->with('global', '課程已刪除');
    }

    public function addToTable(Request $request, Course $course)
    {
        $this->validate($request, [
            'course_table_id' => 'required|exists:course_tables,id',
        ]);
        $courseTable = CourseTable::find($request->get('course_table_id'));
        $user = auth()->user();
        if ($courseTable->user_id != $user->id) {
            return redirect()->back()->with('warning', '僅能選擇自己的課表');
        }
        $courseTable->courses()->syncWithoutDetaching([$course->id]);

        return redirect()->back()->with('global', '已新增至 ' . $courseTable->name);
    }

    public function removeFromTable(Request $request, Course $course)
    {
        $this->validate($request, [
            'course_table_id' => 'required|exists:course_tables,id',
        ]);
        $courseTable = CourseTable::find($request->get('course_table_id'));
        $user = auth()->user();
        if ($courseTable->user_id != $user->id) {
            return redirect()->back()->with('warning', '僅能選擇自己的課表');
        }
        $courseTable->courses()->detach($course);

        return redirect()->back()->with('global', '已從 ' . $courseTable->name . ' 移除');
    }
}
