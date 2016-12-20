@extends('layouts.app')

@section('title', '節次管理')

@section('content')
    <h1>節次管理</h1>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>週日</th>
                <th>週一</th>
                <th>週二</th>
                <th>週三</th>
                <th>週四</th>
                <th>週五</th>
                <th>週六</th>
            </tr>
            </thead>
            <tbody>
            @foreach(range(1,14) as $number)
                <tr>
                    <td>{{ $number }}</td>
                    @foreach(range(0,6) as $weekday)
                        <td>
                            {{ $periodTable[$weekday][$number] }}
                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
