@extends('teacher.show')

@section('content')
    @parent
    <div class="text-xs-center">
        <a href="{{ route('admin.teacher.index') }}" class="btn btn-secondary">返回教師管理</a>
    </div>
@endsection
