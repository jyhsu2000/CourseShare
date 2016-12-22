<a href="{{ route('courseTable.show', $id) }}" class="btn btn-primary" title="檢視課表">
    <i class="fa fa-search" aria-hidden="true"></i>
</a>
{!! Form::open(['route' => ['courseTable.destroy', $id], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除此課表嗎？');"]) !!}
<button type="submit" class="btn btn-danger" title="刪除課表">
    <i class="fa fa-times" aria-hidden="true"></i>
</button>
{!! Form::close() !!}
