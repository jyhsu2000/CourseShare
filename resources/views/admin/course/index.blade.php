@extends('layouts.app')

@section('title', '課程管理')

@section('content')
    <h1>課程管理</h1>
    <a href="{{ route('admin.course.create') }}" class="btn btn-primary">新增課程</a>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importForm">
        匯入課程
    </button>
    <div class="modal fade" id="importForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">匯入課程</h4>
                </div>
                {{ Form::open(['route' => 'admin.course.import', 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        {{ Form::file('files[]', ['accept' => '.json']) }}
                        @if ($errors->has('files'))
                            <br/>
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">匯入</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
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
    @if(session('errors'))
        <script>
            $(function () {
                $('#importForm').modal({show: true});
            });
        </script>
    @endif
    {!! $dataTable->scripts() !!}
@endsection
