@inject('ratePresenter', 'App\Presenters\RatePresenter')
@php($userRate = $ratePresenter->getUserRate())
@php($rates = $ratePresenter->getRates())
@php($isEditMode = isset($userRate) && $userRate != null)
@php($methodText = $isEditMode ? '編輯' : '新增')
<div class="card">
    <div class="card-header">
        評價
    </div>
    <div class="card-block">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rateForm">
            {{ $methodText }}評價
        </button>
        <div class="modal fade" id="rateForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">{{ $methodText }}評價</h4>
                    </div>
                    @if($isEditMode)
                        {{ Form::open(['route' => ['rate.update', $userRate], 'method' => 'put']) }}
                        {{ Form::model($userRate) }}
                    @else
                        {{ Form::open(['route' => 'rate.store']) }}
                        {{ Form::hidden('rateable_type', $ratePresenter->getRateableType()) }}
                        {{ Form::hidden('rateable_id', $ratePresenter->getRateableId()) }}
                    @endif
                    <div class="modal-body">
                        <div class="form-group">
                            {{ Form::label('star','星等評價') }}
                            {{ Form::select('star', $ratePresenter->getStarSelectOptions(), null, ['placeholder' => '','class' => 'form-control', 'required']) }}
                            @if ($errors->has('star'))
                                <br/>
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('star') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('comment','評語') }}
                            {{ Form::textarea('comment', null, ['class' => 'form-control']) }}
                            @if ($errors->has('comment'))
                                <br/>
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('comment') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">提交</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="card-block">
        評價次數：{{ $rates->count() }} / 平均評價：{{ $ratePresenter->getAverageRate() ?: '-'}}
    </div>
    @foreach($rates as $rate)
        <div class="card-block">
            <p class="card-title" style="font-size: 1.5em">
                <span class="text-success">{!! $ratePresenter->getStarIcon($rate->star) !!}</span>
                <span class="float-sm-right text-sm-right" style="white-space: nowrap">
                {{ Html::image(Gravatar::src($rate->user->email, 30), null, ['class'=>'img-thumbnail']) }}
                    @if(Entrust::can('user.view') || Entrust::can('user.manage'))
                        {{ link_to_route('user.show', $rate->user->name, $rate->user) }}
                    @else
                        {{ $rate->user->name }}
                    @endif
                    <br/>
                    <small class="text-muted" style="font-size: 0.5em">
                        Last updated {{ $rate->updated_at->diffForHumans() }}
                    </small>
                </span>
            </p>
            <blockquote class="blockquote">
                {!! nl2br(htmlspecialchars($rate->comment)) !!}
            </blockquote>
        </div>
    @endforeach
</div>
