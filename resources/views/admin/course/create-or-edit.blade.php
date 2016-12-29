@extends('layouts.app')

@php($isEditMode = isset($course))
@php($methodText = $isEditMode ? '編輯' : '新增')

@section('title', $methodText . '課程')

@section('content')
    <div class="card">
        <div class="card-header">
            @if($isEditMode)
                {{ $course->sub_name }} - 編輯課程
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
                {{ Form::label('id', '課程編號', ['class' => 'form-control-label']) }}
                {{ Form::text('id', null, ['class' => 'form-control', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::label('sub_name', '科目名稱', ['class' => 'form-control-label']) }}
                {{ Form::text('sub_name', null, ['class' => 'form-control', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::label('scr_period', '上課時間/上課教室/授課教師', ['class' => 'form-control-label']) }}
                {{ Form::text('scr_period', null, ['class' => 'form-control', 'placeholder' => '格式如：(一)01-03 資電311 (二)07 資電222 某某老師']) }}
            </div>
                <div class="form-group">
                    {{ Form::label('scj_scr_mso', '必選修', ['class' => 'form-control-label']) }}
                    {{ Form::text('scj_scr_mso', null, ['class' => 'form-control']) }}
                </div>
            <div class="form-group">
                {{ Form::label('scr_acptcnt', '實收名額', ['class' => 'form-control-label']) }}
                {{ Form::number('scr_acptcnt', null, ['class' => 'form-control', 'min' => 0]) }}
            </div>
            <div class="form-group">
                {{ Form::label('scr_precnt', '開放名額', ['class' => 'form-control-label']) }}
                {{ Form::number('scr_precnt', null, ['class' => 'form-control', 'min' => 0]) }}
            </div>
            <div class="form-group">
                {{ Form::label('scr_selcode', '選課代號', ['class' => 'form-control-label']) }}
                {{ Form::text('scr_selcode', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('scr_credit', '學分', ['class' => 'form-control-label']) }}
                {{ Form::number('scr_credit', null, ['class' => 'form-control', 'min' => 0]) }}
            </div>
            <div class="form-group">
                {{ Form::label('unt_ls', 'unt_ls', ['class' => 'form-control-label']) }}
                {{ Form::number('unt_ls', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('scr_dup', 'scr_dup', ['class' => 'form-control-label']) }}
                {{ Form::text('scr_dup', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('scr_remarks', '備註', ['class' => 'form-control-label']) }}
                {{ Form::text('scr_remarks', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('cls_name', '班級', ['class' => 'form-control-label']) }}
                {{ Form::text('cls_name', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('sub_id', '課程ID', ['class' => 'form-control-label']) }}
                {{ Form::text('sub_id', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('cls_id', '班級ID', ['class' => 'form-control-label']) }}
                {{ Form::text('cls_id', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('scr_exambf', '提前考', ['class' => 'form-control-label']) }}
                <div class="form-control">
                    <label class="custom-control custom-radio">
                        {{ Form::radio('scr_exambf', '是', null, ['class' => 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">是</span>
                    </label>
                    <label class="custom-control custom-radio">
                        {{ Form::radio('scr_exambf', '否', null, ['class' => 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">否</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('scr_examid', '期中考', ['class' => 'form-control-label']) }}
                <div class="form-control">
                    <label class="custom-control custom-radio">
                        {{ Form::radio('scr_examid', '是', null, ['class' => 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">是</span>
                    </label>
                    <label class="custom-control custom-radio">
                        {{ Form::radio('scr_examid', '否', null, ['class' => 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">否</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('scr_examfn', '期末考', ['class' => 'form-control-label']) }}
                <div class="form-control">
                    <label class="custom-control custom-radio">
                        {{ Form::radio('scr_examfn', '是', null, ['class' => 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">是</span>
                    </label>
                    <label class="custom-control custom-radio">
                        {{ Form::radio('scr_examfn', '否', null, ['class' => 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">否</span>
                    </label>
                </div>
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
