@extends('layouts.app')

@section('title', '課程清單')

@section('content')
    <h1>課程清單</h1>
    @if(session('lastCourseTableId_' . auth()->user()->id))
        <a href="{{ route('courseTable.show', session('lastCourseTableId_' . auth()->user()->id)) }}"
           class="btn btn-secondary">
            回到課表
        </a>
    @endif
    <a href="{{ route('course.create') }}" class="btn btn-primary">新增課程</a>
    <div>
        @include('course.courseFilter')
    </div>
    {!! $dataTable->table() !!}
@endsection

@section('js')
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
