<a href="{{ route('admin.teacher.show', $id) }}" class="btn btn-primary" title="檢視教師">
    <i class="fa fa-search" aria-hidden="true"></i>
</a>
{!! Form::open(['route' => ['admin.teacher.destroy', $id], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除此教師嗎？');"]) !!}
<button type="submit" class="btn btn-danger" title="刪除教師">
    <i class="fa fa-times" aria-hidden="true"></i>
</button>
{!! Form::close() !!}
