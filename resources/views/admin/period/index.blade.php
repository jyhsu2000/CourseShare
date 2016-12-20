@extends('layouts.app')

@section('title', '節次管理')

@section('content')
    <h1>節次管理</h1>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-xs-center">節次</th>
                <th class="text-xs-center">週日</th>
                <th class="text-xs-center">週一</th>
                <th class="text-xs-center">週二</th>
                <th class="text-xs-center">週三</th>
                <th class="text-xs-center">週四</th>
                <th class="text-xs-center">週五</th>
                <th class="text-xs-center">週六</th>
            </tr>
            </thead>
            <tbody>
            @foreach(range(1,14) as $number)
                <tr>
                    <td class="text-xs-center">
                        第{{ $number }}節
                    </td>
                    @foreach(range(0,6) as $weekday)
                        <td class="text-xs-center">
                            <a href="{{ route('admin.period.show', $periodTable[$weekday][$number]) }}">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
