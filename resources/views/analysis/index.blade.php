@extends('layouts.app')

@section('title', '空堂分析')

@section('content')
    <h1>空堂分析</h1>
    <div class="card">
        <div class="card-header">
            分析課表
        </div>
        <div class="card-block">
            <div class="col-md-6">
                @if(count($courseTables))
                    <ul>
                        @foreach($courseTables as $courseTable)
                            <li>
                                {{ link_to_route('courseTable.show', $courseTable->name, $courseTable, ['target' => '_blank']) }}
                                {{ link_to_route('analysis.remove', '[-]', $courseTable, ['title' => '從分析清單移除', 'class' => 'text-danger']) }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    請先至課表頁面將課表加入分析清單
                @endif
            </div>
            <div class="col-md-6">
                快速新增：
                <ul>
                    @foreach($myCourseTables as $courseTable)
                        <li>
                            {{ link_to_route('courseTable.show', $courseTable->name, $courseTable, ['target' => '_blank']) }}
                            {{ link_to_route('analysis.add', '[+]', $courseTable, ['title' => '加入到分析清單', 'class' => 'text-success']) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @if(count($courseTables))
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
                                <td class="text-xs-center hover bg-danger" style="font-size: 2em"
                                    title="這個時段有 {{ $periodTable[$weekday][$number] }} 門課">
                                    {{ $periodTable[$weekday][$number] }}
                                </td>
                            @else
                                <td class="text-xs-center hover text-success"
                                    title="這個時段大家都有空">
                                    <i class="fa fa-check fa-2x" aria-hidden="true"></i>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection

