@extends('layouts.master')

@section('scripts-before')
    <script src="{{ asset('public/assets/js/modules/users.js') }}"></script>
@stop

@section('content')
    {!! Breadcrumbs::render('config.index') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Parâmetros do Sistema</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if (notify()->ready())
                            <div class="alert alert-{{ notify()->type() }} no-border">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                            class="sr-only">Close</span></button>
                                <span class="text-semibold"><i
                                            class="icon-{{ notify()->type() == 'success'?'checkmark5':'warning' }}"></i></span> {{ notify()->message() }}
                                .
                            </div>
                        @endif
                        <div class="tabbable tab-content-bordered">
                            <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                                <li class="active"><a href="#bordered-justified-tab1" data-toggle="tab">Notificações</a></li>
                                <li><a href="#bordered-justified-tab2" data-toggle="tab">Padronização</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane has-padding active" id="bordered-justified-tab1">
                                    <fieldset>
                                        <legend>Notificações de Email</legend>
                                        <form action="{{ route('config.store') }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Frequência 90 dias:</label>
                                                        <input type="number" value="{{ $setting['fq_90'] }}" name="fq_90" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Frequência 60 dias:</label>
                                                        <input type="number" value="{{ $setting['fq_60'] }}" name="fq_60" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Frequência 30 dias:</label>
                                                        <input type="number" value="{{ $setting['fq_30'] }}" name="fq_30" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <button type="submit" class="btn btn-primary">Gravar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>

                                <div class="tab-pane has-padding" id="bordered-justified-tab2">
                                    Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid laeggin.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop