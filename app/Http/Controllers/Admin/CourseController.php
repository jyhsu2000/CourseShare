<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\CoursesDataTable;
use Webpatser\Uuid\Uuid;

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
        $this->validate($request, [
            'year'        => 'required|integer',   //TODO: 檢查是否落在Course的yearRange
            'semester'    => 'required|in:1,2',
            'id'          => ['max:255', Rule::unique(app(Course::class)->getTable())],
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
        $id = $request->get('id') ?: Uuid::generate()->string;
        $properties = array_merge($request->all(), [
            'id'          => $id,
            'scr_acptcnt' => (int) $request->get('scr_acptcnt'),
            'scr_precnt'  => (int) $request->get('scr_precnt'),
            'scr_credit'  => (int) $request->get('scr_credit'),
            'unt_ls'      => (int) $request->get('unt_ls'),
        ]);
        $course = Course::create($properties);

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
        $courseTables = $course->courseTables()->where('public', true)->get();

        return view('admin.course.show', compact(['course', 'courseTables']));
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

    public function import(Request $request)
    {
        $this->validate($request, [
            'files' => 'required',
        ]);
        $uploadedFiles = $request->file('files');

        $count = 0;
        $countCreated = 0;
        $countUpdated = 0;
        $errorFiles = [];
        $errorCourses = [];
        foreach ($uploadedFiles as $uploadedFile) {
            /* @var UploadedFile $uploadedFile */
            $path = $uploadedFile->getPathname();
            $fileContent = \File::get($path);
            if (!$fileContent) {
                $errorFiles[] = $uploadedFile->getClientOriginalName();
                continue;
            }
            try {
                $json = json_decode($fileContent);
            } catch (\Exception $exception) {
                $errorFiles[] = $uploadedFile->getClientOriginalName();
                continue;
            }
            foreach ($json as $courseId => $course) {
                $count++;
                //檢查課程是否已存在
                $existCourse = Course::find($courseId);
                $courseArray = (array) $course;
                try {
                    if ($existCourse) {
                        //已存在，更新課程
                        $existCourse->update(array_merge($courseArray, [
                            'scr_remarks' => $request->get('scr_remarks') ?: '',
                        ]));
                        $countUpdated++;
                        continue;
                    }
                    //不存在，新增課程
                    Course::create(array_merge($courseArray, [
                        'id'          => $courseId,
                        'scr_remarks' => $request->get('scr_remarks') ?: '',
                    ]));
                    $countCreated++;
                } catch (\Exception $exception) {
                    $errorCourses[] = $courseId;
                }
            }
        }
        $message = "匯入完成（新增：{$countCreated}，更新：{$countUpdated}，總計：{$count}）";
        if (count($errorFiles)) {
            $message .= '失敗檔案：' . implode('、', $errorFiles);
        }
        if (count($errorCourses)) {
            $message .= '失敗課程：' . implode('、', $errorCourses);
        }

        return redirect()->route('admin.course.index')
            ->with('global', $message);
    }
}
