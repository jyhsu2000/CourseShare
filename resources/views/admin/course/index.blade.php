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
        @include('course.courseFilter')
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
    <script>
        $(function () {
            var $filter = $('#dataTableBuilder_filter');
            $filter.html('搜尋選課代號：<input id="codeFilter" type="text" placeholder="" size="6" class="form-control input-sm" /> ' + $filter.html());
            var table = window.LaravelDataTables["dataTableBuilder"];
            $('#codeFilter').on('keyup change', function () {
                table.column(0)
                    .search(this.value)
                    .draw();
            });
        });
    </script>
@endsection
