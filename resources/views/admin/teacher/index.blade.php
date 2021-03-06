@extends('layouts.app')

@section('title', '教師管理')

@section('content')
    <h1>教師管理</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createForm" data-whatever="@mdo">
        新增教師
    </button>
    <div class="modal fade" id="createForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">建立教師</h4>
                </div>
                {{ Form::open(['route' => 'admin.teacher.store']) }}
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="form-control-label">教師名稱：</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                               class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}">
                        @if ($errors->has('name'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">建立</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    @if(session('errors'))
        <script>
            $(function () {
                $('#createForm').modal({show: true});
            });
        </script>
    @endif
    {!! $dataTable->scripts() !!}
@endsection
