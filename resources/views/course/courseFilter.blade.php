{{ Form::open(['class' => 'form-inline', 'method' => 'get']) }}
{{ Form::label('year','學年度：') }}
{{ Form::select('year', \App\Course::getYearRange(), Request::get('year'), ['placeholder' => '- 學年度 -', 'class' => 'form-control']) }}
{{ Form::label('semester','學期：') }}
{{ Form::select('semester', [1=>'上學期',2=>'下學期'], Request::get('semester'), ['placeholder' => '- 學期 -', 'class' => 'form-control']) }}
{{ Form::submit('提交', ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
