@extends('layouts.app')

@section('title', '課程清單')

@section('content')
    <h1>課程清單</h1>
    @if(session('lastCourseTableId_' . auth()->user()->id))
        <a href="{{ route('courseTable.show', session('lastCourseTableId_' . auth()->user()->id)) }}"
           class="btn btn-secondary">
            回到課表
        </a>
    @endif
    <a href="{{ route('course.create') }}" class="btn btn-primary">新增課程</a>
    <div>
        @include('course.courseFilter')
    </div>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
