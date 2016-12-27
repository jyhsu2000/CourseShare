@extends('layouts.app')

@section('title', '課程清單')

@section('content')
    <h1>課程清單</h1>
    <a href="{{ route('course.create') }}" class="btn btn-primary">新增課程</a>
    <div>
        @include('course.courseFilter')
    </div>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
