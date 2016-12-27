@extends('layouts.app')

@section('title', '首頁')

@section('css')
    <style>
        .jumbotron {
            text-align: center;
            word-break: break-all;
            background: rgba(100, 100, 100, .6);
            margin-top: 20vh;
            padding-top: 40px;
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="jumbotron">
        <h1 class="display-1">{{ config('app.name') }}</h1>
        <h2 class="display-3">課程分享平台</h2>
        <a href="{{ route('courseTable.my') }}" class="btn btn-primary btn-lg" style="margin-top: 5vh;" title="Let's GO!!">GO!</a>
    </div>
@endsection
