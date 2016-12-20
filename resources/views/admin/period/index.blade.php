@extends('layouts.app')

@section('title', '節次管理')

@section('css')
    <style>
        .bg {
            background-color: #2a88bd !important;
        }

        td[data-href] {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <h1>節次管理</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
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
                    <td class="text-xs-center" style="white-space: nowrap">
                        第{{ $number }}節<br/>
                        {{ \App\Period::getTimeRangeString($number) }}
                    </td>
                    @foreach(range(0,6) as $weekday)
                        @if(isset($periodTable[$weekday][$number]))
                            <td class="text-xs-center hover"
                                data-href="{{ route('admin.period.show', $periodTable[$weekday][$number]) }}">
                                <i class="fa fa-search-plus text-primary" aria-hidden="true"></i>
                            </td>
                        @else
                            <td class="text-xs-center"></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('table tbody tr td.hover').mouseenter(function () {
                $(this).addClass('bg');
            }).mouseleave(function () {
                $(this).removeClass('bg');
            });
            $('table tbody tr td.hover[data-href]').click(function () {
                window.document.location = $(this).data("href");
            });
        });
    </script>
@endsection
