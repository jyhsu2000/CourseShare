@if($user_id == auth()->user()->id)
<a href="{{ route('course.show', $id) }}" class="btn btn-primary" title="檢視課程">
    <i class="fa fa-search" aria-hidden="true"></i>
</a>
{!! Form::open(['route' => ['course.destroy', $id], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除此課程嗎？');"]) !!}
<button type="submit" class="btn btn-danger" title="刪除課程">
    <i class="fa fa-times" aria-hidden="true"></i>
</button>
{!! Form::close() !!}
@endif
