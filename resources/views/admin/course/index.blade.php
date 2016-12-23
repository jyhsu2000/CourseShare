@extends('layouts.app')

@section('title', '課程管理')

@section('content')
    <h1>課程管理</h1>
    <a href="{{ route('admin.course.create') }}" class="btn btn-primary">新增課程</a>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
