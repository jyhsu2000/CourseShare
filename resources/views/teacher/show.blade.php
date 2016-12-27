@extends('layouts.app')

@section('title', $teacher->name . ' - 教師資訊')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $teacher->name }} - 教師資訊
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-4 text-md-right">評價：</div>
                <div class="col-md-8">{{ $teacher->star }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-md-right">名稱：</div>
                <div class="col-md-8">{{ $teacher->name }}</div>
            </div>
        </div>
        <div class="card-block">
            <div class="text-xs-center">
                <a href="{{ route('teacher.index') }}" class="btn btn-secondary">返回教師清單</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            課程
        </div>
        <div class="card-block">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>選課代號</th>
                    <th>科目名稱</th>
                    <th>上課時間/上課教室/授課教師</th>
                    <th>評價</th>
                </tr>
                </thead>
                @foreach($teacher->courses as $course)
                    <tr>
                        <td>{{ $course->scr_selcode }}</td>
                        <td>{{ link_to_route('course.show', $course->sub_name, $course) }}</td>
                        <td>{{ $course->scr_period }}</td>
                        <td>{{ $course->star }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    @include('rate.panel')
@endsection

@section('js')
    @if(session('errors'))
        @if($errors->has('star') || $errors->has('comment'))
            <script>
                $(function () {
                    $('#rateForm').modal({show: true});
                });
            </script>
        @endif
    @endif
@endsection
