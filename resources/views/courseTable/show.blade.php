@extends('layouts.app')

@section('title', $courseTable->name .  ' - 課表')

@section('css')
    <style>
        .bg {
            background-color: #2a88bd !important;
        }
        th, td {
            white-space: nowrap;
        }
    </style>
@endsection

@section('content')
    <h1>{{ $courseTable->name }} - 課表</h1>
    <a href="{{ route('courseTable.index') }}" class="btn btn-secondary">返回</a>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Form">
        修改課表名稱
    </button>
    <div class="modal fade" id="Form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">修改課表名稱</h4>
                </div>
                {{ Form::open(['route' => ['courseTable.update', $courseTable], 'method' => 'put']) }}
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="form-control-label">課表名稱：</label>
                        <input id="name" type="text" name="name" value="{{ $courseTable->name ?: old('name') }}" required
                               class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}">
                        @if ($errors->has('name'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">修改</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-xs-center">節次</th>
                <th class="text-xs-center">週日</th>
                <th class="text-xs-center">週一</th>
                <th class="text-xs-center">週二</th>
                <th class="text-xs-center">週三</th>
                <th class="text-xs-center">週四</th>
                <th class="text-xs-center">週五</th>
                <th class="text-xs-center">週六</th>
            </tr>
            </thead>
            <tbody>
            @foreach(range(1,14) as $number)
                <tr>
                    <td class="text-xs-center" style="white-space: nowrap">
                        第{{ $number }}節<br/>
                        {{ \App\Period::getTimeRangeString($number) }}
                    </td>
                    @foreach(range(0,6) as $weekday)
                        @if(isset($periodTable[$weekday][$number]))
                            @if(count($periodTable[$weekday][$number])==1)
                                <td class="text-xs-center hover bg-info">
                                    @foreach($periodTable[$weekday][$number] as $periodCourse)
                                        {{ link_to_route('course.show', $periodCourse->name, $periodCourse->id, ['target' => '_blank']) }}<br/>
                                        {{ $periodCourse->teacher }}<br/>
                                        {{ $periodCourse->location }}<br/>
                                    @endforeach
                                </td>
                            @else
                                <td class="text-xs-center hover bg-danger">
                                    衝堂<br/>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#conflictForm">
                                        (顯示衝堂課程)
                                    </a>
                                    <div class="modal fade" id="conflictForm" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">衝堂課程</h4>
                                                </div>
                                                @foreach($periodTable[$weekday][$number] as $periodCourse)
                                                    {{ link_to_route('course.show', $periodCourse->name, $periodCourse->id, ['target' => '_blank']) }}<br/>
                                                    {{ $periodCourse->teacher }}<br/>
                                                    {{ $periodCourse->location }}<br/>
                                                    <br/>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        @else
                            <td class="text-xs-center"></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-header">
            課程清單
        </div>
        <div class="card-block table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>選課代號</th>
                    <th>科目名稱</th>
                    <th>上課時間/上課教室/授課教師</th>
                    <th>操作</th>
                </tr>
                </thead>
                @foreach($courseTable->courses as $course)
                    <tr>
                        <td>{{ $course->scr_selcode }}</td>
                        <td>
                            {{ link_to_route('course.show', $course->sub_name, $course, ['target' => '_blank']) }}
                        </td>
                        <td>{{ $course->scr_period }}</td>
                        <td>
                            {{ Form::open(['route' => ['course.removeFromTable', $course]]) }}
                            {{ Form::hidden('course_table_id', $courseTable->id) }}
                            <button type="submit" class="btn btn-danger">從課表移除</button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </table>
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
    <script>
        $(function () {
            $('table tbody tr td.hover').mouseenter(function () {
                $(this).addClass('bg');
            }).mouseleave(function () {
                $(this).removeClass('bg');
            });
        });
    </script>
@endsection