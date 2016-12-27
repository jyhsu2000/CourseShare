@extends('layouts.app')

@section('title', '公開課表')

@section('content')
    <h1>公開課表</h1>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
