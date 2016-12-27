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
