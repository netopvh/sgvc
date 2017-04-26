@extends('layouts.master')

@section('scripts-after')
    <script src="{{ asset('public/assets/js/plugins/buttons/jQuery.print/jQuery.print.js') }}"></script>
    <script src="{{ asset('public/assets/js/modules/contratos.js') }}"></script>
@stop

@section('content')
    {!! Breadcrumbs::render('contratos.view') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Visualizar Contrato</h5>
                    </div>
                    <div class="panel-body">
                        <div id="print">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-7">
                                        <img src="{{ asset('public/assets/images/fiero.png') }}" alt="Sistema Fiero"
                                             class="img-responsive">
                                    </div>
                                    <div class="col-xs-4">
                                        <b>Contrato Nº: </b> {{ $contrato->numero_ano }} <br>
                                        <b>Vigência: </b> {{ $contrato->inicio }} - {{ $contrato->encerramento }} <br>
                                        <b>Contratante: </b>{{ $contrato->casa->name }} <br>
                                        @if(! empty($contrato->unidade_id))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <b>Unidade:</b> {{ $contrato->unidade->name }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <fieldset>
                                            <legend>
                                                <span class="text-size-large">Informações do Contratado</span>
                                            </legend>
                                            @foreach($contrato->empresas as $empresa)
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        @if(strlen($empresa->cpf_cnpj) == 14)
                                                            <b>CNPJ: </b>{{ mask('##.###.###/####-##', $empresa->cpf_cnpj) }}

                                                        @else
                                                            <b>CPF: </b>{{ mask('###.###.###-##', $empresa->cpf_cnpj) }}
                                                        @endif
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <b>Razão Social: </b>{{ $empresa->razao }}
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <b>Tipo: </b>{{ $tipo_pessoa[$empresa->tipo_pessoa] }}
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-xs-5">
                                                        <b>Responsável: </b>{{ $empresa->responsavel }}
                                                    </div>
                                                    <div class="col-xs-5">
                                                        <b>E-mail: </b>{{ $empresa->email }}
                                                    </div>
                                                </div>
                                                <hr class="line">
                                            @endforeach
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <fieldset>
                                            <legend>
                                                <span class="text-size-large">Informações do Contrato</span>
                                            </legend>
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <b>Total do Contrato: </b>
                                                    R$ {{ number_format($contrato->total, 2, ',', '.') }}
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Mensalidade do Contrato: </b>
                                                    R$ {{ number_format($contrato->mensal, 2, ',', '.') }}
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Situação: </b>
                                                    @if($contrato->status == 'V')
                                                        <span class="label label-success">Vigente</span>
                                                    @endif
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Contrato Aditivado?: </b>
                                                    @if($contrato->aditivado == 'S')
                                                        Sim
                                                    @else
                                                        Não
                                                    @endif
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <b>Objeto do Contrato: </b> <br>
                                                    {!! nl2br($contrato->objeto) !!}
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <fieldset>
                                                        <legend>
                                                            <span class="text-size-large">Gestores e Fiscais do Contrato</span>
                                                        </legend>
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <b>Gestores:</b> <br>
                                                                @foreach($contrato->gestores as $gestor)
                                                                    {{ $gestor->name }},
                                                                @endforeach
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <b>Fiscais:</b> <br>
                                                                @foreach($contrato->fiscais as $fiscal)
                                                                    {{ $fiscal->name }},
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-5">
                                        <button class="btn btn-primary" id="send"><i class="icon-printer"></i> Imprimir</button>
                                        <button class="btn btn-info" onclick="window.location.href='{{ route('contratos.index') }}'"><i class="icon-reply"></i> Voltar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop