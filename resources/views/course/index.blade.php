@extends('layouts.app')

@section('title', '課程清單')

@section('content')
    <h1>課程清單</h1>
    <a href="{{ route('course.create') }}" class="btn btn-primary">新增課程</a>
    <div>
        {{ Form::open(['class' => 'form-inline', 'method' => 'get']) }}
        {{ Form::label('year','學年度：') }}
        {{ Form::select('year', \App\Course::getYearRange(), Request::get('year'), ['placeholder' => '- 學年度 -', 'class' => 'form-control']) }}
        {{ Form::label('semester','學期：') }}
        {{ Form::select('semester', [1=>'上學期',2=>'下學期'], Request::get('semester'), ['placeholder' => '- 學期 -', 'class' => 'form-control']) }}
        {{ Form::submit('提交', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
