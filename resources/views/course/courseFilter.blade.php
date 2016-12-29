<div class="card card-outline-primary text-xs-center">
    <div class="card-block">
        {{ Form::open(['class' => 'form-inline', 'method' => 'get', 'style' => 'display: inline']) }}
        {{ Form::label('year','學年度：') }}
        {{ Form::select('year', \App\Course::getYearRange(), Request::get('year'), ['placeholder' => '- 學年度 -', 'class' => 'form-control']) }}
        {{ Form::label('semester','學期：') }}
        {{ Form::select('semester', [1=>'上學期',2=>'下學期'], Request::get('semester'), ['placeholder' => '- 學期 -', 'class' => 'form-control']) }}
        {{ Form::label('weekday','星期：') }}
        {{ Form::select('weekday', \App\Period::getWeekdaySelectOptions(), Request::get('weekday'), ['placeholder' => '- 星期幾 -', 'class' => 'form-control']) }}
        {{ Form::label('periodNumber','節次：') }}
        {{ Form::select('periodNumber', \App\Period::getPeriodNumberSelectOptions(), Request::get('periodNumber'), ['placeholder' => '- 節次 -', 'class' => 'form-control']) }}
        {{ Form::submit('提交', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
        <a href="{{ URL::current() }}" class="btn btn-secondary">清除</a>
    </div>
</div>
