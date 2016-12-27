@extends('layouts.app')

@section('title', '教師清單')

@section('content')
    <h1>教師清單</h1>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
