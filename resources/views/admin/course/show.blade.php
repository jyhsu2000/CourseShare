@extends('course.show')

@section('content')
    @parent
    @if(Entrust::can('course.manage'))
        <div class="text-xs-center">
            <a href="{{ route('admin.course.edit', $course) }}" class="btn btn-primary">編輯課程</a>
            {!! Form::open(['route' => ['admin.course.destroy', $course], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除此課程嗎？');"]) !!}
            <button type="submit" class="btn btn-danger">刪除課程</button>
            {!! Form::close() !!}
        </div>
    @endif
@endsection
