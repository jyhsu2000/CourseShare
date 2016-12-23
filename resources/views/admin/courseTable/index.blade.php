@extends('layouts.app')

@section('title', '課表管理')

@section('content')
    <h1>課表管理</h1>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
