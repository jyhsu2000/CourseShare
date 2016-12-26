@extends('layouts.app')

@section('title', $course->sub_name . ' - 課程資訊')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $course->sub_name }} - 課程資訊
        </div>
        <div class="card-block">
            <table class="table table-hover">
                <tr>
                    <td class="text-md-right">名稱：</td>
                    <td>{{ $course->sub_name }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">學年：</td>
                    <td>{{ $course->year }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">學期：</td>
                    <td>{{ $course->semester }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">上課時間　<br/>/上課教室　<br/>/授課教師：</td>
                    <td>{{ $course->scr_period }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">必選修：</td>
                    <td>{{ $course->scj_scr_mso }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">實收名額：</td>
                    <td>{{ $course->scr_acptcnt }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">開放名額：</td>
                    <td>{{ $course->scr_precnt }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">選課代號：</td>
                    <td>{{ $course->scr_selcode }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">學分：</td>
                    <td>{{ $course->scr_credit }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">unt_ls：</td>
                    <td>{{ $course->unt_ls }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">scr_dup：</td>
                    <td>{{ $course->scr_dup }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">備註：</td>
                    <td>{{ $course->scr_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">班級：</td>
                    <td>{{ $course->cls_name }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">課程ID：</td>
                    <td>{{ $course->sub_id }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">班級ID：</td>
                    <td>{{ $course->cls_id }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">提前考：</td>
                    <td>{{ $course->scr_exambf }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">期中考：</td>
                    <td>{{ $course->scr_examid }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">期末考：</td>
                    <td>{{ $course->scr_examfn }}</td>
                </tr>
            </table>
        </div>
        <div class="card-block">
            <div class="text-xs-center">
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
                    <button type="submit" class="btn btn-primary" formaction="{{ route('course.addToTable', $course) }}">
                        新增至課表
                    </button>
                    <button type="submit" class="btn btn-danger" formaction="{{ route('course.removeFromTable', $course) }}">
                        從課表移除
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    @if(session('errors'))
        <script>
            $(function () {
                $('#Form').modal({show: true});
            });
        </script>
    @endif
@endsection
