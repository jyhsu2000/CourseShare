@extends('layouts.app')

@section('title', $course->sub_name . ' - 課程資訊')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $course->sub_name }} - 課程資訊
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-4 text-md-right">評價：</div>
                <div class="col-md-8">{{ $course->star }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">名稱：</div>
                <div class="col-md-8">{{ $course->sub_name }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">學年：</div>
                <div class="col-md-8">{{ $course->year }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">學期：</div>
                <div class="col-md-8">{{ $course->semester }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">上課時間/上課教室/授課教師：</div>
                <div class="col-md-8">{{ $course->scr_period }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">必選修：</div>
                <div class="col-md-8">{{ $course->scj_scr_mso }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">實收名額：</div>
                <div class="col-md-8">{{ $course->scr_acptcnt }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">開放名額：</div>
                <div class="col-md-8">{{ $course->scr_precnt }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">選課代號：</div>
                <div class="col-md-8">{{ $course->scr_selcode }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">學分：</div>
                <div class="col-md-8">{{ $course->scr_credit }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">unt_ls：</div>
                <div class="col-md-8">{{ $course->unt_ls }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">scr_dup：</div>
                <div class="col-md-8">{{ $course->scr_dup }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">備註：</div>
                <div class="col-md-8">{{ $course->scr_remarks }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">班級：</div>
                <div class="col-md-8">{{ $course->cls_name }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">課程ID：</div>
                <div class="col-md-8">{{ $course->sub_id }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">班級ID：</div>
                <div class="col-md-8">{{ $course->cls_id }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">提前考：</div>
                <div class="col-md-8">{{ $course->scr_exambf }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">期中考：</div>
                <div class="col-md-8">{{ $course->scr_examid }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">期末考：</div>
                <div class="col-md-8">{{ $course->scr_examfn }}</div>
            </div>
        </div>
        <div class="card-block">
            <div class="text-xs-center">
                @if(session('lastCourseTableId_' . auth()->user()->id))
                    <a href="{{ route('courseTable.show', session('lastCourseTableId_' . auth()->user()->id)) }}"
                       class="btn btn-secondary">
                        回到課表
                    </a>
                @endif
                <a href="{{ route('course.index') }}" class="btn btn-secondary">返回課程清單</a>
                @if($course->user_id == auth()->user()->id)
                    <a href="{{ route('course.edit', $course) }}" class="btn btn-primary">編輯課程</a>
                @endif
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Form">
                    新增至課表/從課表移除
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">新增至課表/從課表移除</h4>
                </div>
                {{ Form::open(['route' => ['course.addToTable', $course]]) }}
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::select('course_table_id', auth()->user()->courseTables->pluck('name', 'id'), old('course_table_id'), ['class' => 'form-control']) }}
                        @if ($errors->has('course_table_id'))
                            <br/>
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('course_table_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"
                            formaction="{{ route('course.addToTable', $course) }}">
                        新增至課表
                    </button>
                    <button type="submit" class="btn btn-danger"
                            formaction="{{ route('course.removeFromTable', $course) }}">
                        從課表移除
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            教師
        </div>
        <div class="card-block">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>名稱</th>
                    <th>評價</th>
                </tr>
                </thead>
                @foreach($course->teachers as $teacher)
                    <tr>
                        <td>{{ link_to_route('teacher.show', $teacher->name, $teacher) }}</td>
                        <td>{{ $teacher->star }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            有這門課的課表（限公開課表）
        </div>
        <div class="card-block">
            @foreach($courseTables as $courseTable)
                <div class="col-md-2">
                    <a href="{{ route('courseTable.show', $courseTable) }}">
                        {{ Html::image(Gravatar::src($courseTable->user->email, 30), null, ['class'=>'img-thumbnail']) }}
                        {{ $courseTable->user->name }}
                        - {{ $courseTable->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @include('rate.panel')
@endsection

@section('js')
    @if(session('errors'))
        @if($errors->has('course_table_id'))
            <script>
                $(function () {
                    $('#Form').modal({show: true});
                });
            </script>
        @elseif($errors->has('star') || $errors->has('comment'))
            <script>
                $(function () {
                    $('#rateForm').modal({show: true});
                });
            </script>
        @endif
    @endif
@endsection
