@extends('layouts.app')

@php($isEditMode = isset($course))
@php($methodText = $isEditMode ? '編輯' : '新增')

@section('title', $methodText . '課程')

@section('content')
    <div class="card">
        <div class="card-header">
            @if($isEditMode)
                {{ $course->name }} - 編輯課程
            @else
                新增課程
            @endif
        </div>
        <div class="card-block">
            @if($isEditMode)
                {{ Form::model($course, ['route' => ['admin.course.update', $course], 'method' => 'put']) }}
            @else
                {{ Form::open(['route' => 'admin.course.store']) }}
            @endif
            <div class="form-group">
                {{ Form::label('year', '學年度', ['class' => 'form-control-label']) }}
                {{ Form::select('year', \App\Course::getYearRange(), null, ['placeholder' => '-', 'class' => 'form-control', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::label('semester', '學期', ['class' => 'form-control-label']) }}
                <div class="form-control">
                    <label class="custom-control custom-radio">
                        {{ Form::radio('semester', 1, null, ['class' => 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">上學期</span>
                    </label>
                    <label class="custom-control custom-radio">
                        {{ Form::radio('semester', 2, null, ['class' => 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">下學期</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('name', '名稱', ['class' => 'form-control-label']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
            </div>


            @if($errors->count())
                <div class="alert alert-danger">
                    @foreach($errors->all('<li>:message</li>') as $error)
                        {!! $error !!}
                    @endforeach
                </div>
            @endif
            <div class="form-group row">
                <div class="text-xs-center">
                    @if($isEditMode)
                        <a href="{{ route('admin.course.show', $course) }}" class="btn btn-secondary">返回</a>
                    @else
                        <a href="{{ route('admin.course.index') }}" class="btn btn-secondary">返回</a>
                    @endif
                    <button type="submit" class="btn btn-primary">確認</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
