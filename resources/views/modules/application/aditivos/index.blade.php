@extends('layouts.master')
@section('scripts-before')
    <script src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/mask/jquery-maskmoney/src/jquery.maskMoney.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/notifications/bootbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules/aditivos.js') }}"></script>
@stop
@section('content')
    {!! Breadcrumbs::render('contratos.aditivos') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-11">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Aditivos de Contrato</h5>

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
                                    <!-- FORMULÀRIO DE PERSQUISA DE CONTRATO -->
                            <fieldset>
                                <legend><span class="text-size-large">Pesquisar Contrato</span></legend>
                                <div class="form-group">
                                    <div class="col-lg-6">
                                        <form action="{{ route('aditivos.index') }}" method="get">
                                            <div class="input-group">
												<span class="input-group-btn">
													<button class="btn btn-default btn-icon" type="button"><i
                                                                class="icon-search4"></i></button>
												</span>
                                                <input type="text" name="search" class="form-control"
                                                       placeholder="Numero e Ano do Contrato. Ex: 123/2017">
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit">Pesquisar</button>
												</span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="{{ route('contratos.index') }}" class="btn btn-primary">Listar
                                            Contratos</a>
                                    </div>
                                </div>
                            </fieldset>
                            <!-- FIM DO FORMULÁRIO -->
                            <br><br>
                            @if(isset($contrato))
                                <div class="tabbable tab-content-bordered">
                                    <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                                        <li class="active"><a href="#bordered-justified-tab1" data-toggle="tab">Aditivo
                                                do
                                                Contrato</a></li>
                                        <li><a href="#bordered-justified-tab2" data-toggle="tab">Informações do
                                                Contrato</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <!-- CONTEUDO DO TAB ! -->
                                        <div class="tab-pane has-padding active" id="bordered-justified-tab1">
                                            @if($contrato->aditivado == 'S')
                                                <div class="alert alert-info no-border">
                                                    <button type="button" class="close" data-dismiss="alert">
                                                        <span>&times;</span><span class="sr-only">Close</span></button>
                                                    <span class="text-semibold"><i
                                                                class="icon-alert"></i> Atenção!</span>
                                                    Contrato Aditivado
                                                    <b>{{ $contrato->aditivos->count() }}</b> {{ $contrato->aditivos->count() > 1? 'Vezes': 'Vez'  }}
                                                    .
                                                </div>
                                            @endif
                                            <form action="{{ route('aditivos.store') }}" method="post"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-xs-1">
                                                        <div class="form-group">
                                                            <label>Ano: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="ano">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Total: <span class="text-danger">*</span></label>
                                                            <input type="text" id="total" name="total"
                                                                   class="form-control"
                                                                   data-prefix="R$ " data-thousands="." data-decimal=","
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Mensal:</label>
                                                            <input type="text" id="mensal" name="mensal"
                                                                   class="form-control"
                                                                   data-prefix="R$ " data-thousands="."
                                                                   data-decimal=",">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Início do Contrato: <span
                                                                        class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                    class="icon-calendar"></i></span>
                                                                <input id="inicio" type="text" name="inicio"
                                                                       class="form-control datepicker"
                                                                       required>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Fim do Contrato: <span
                                                                        class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                    class="icon-calendar"></i></span>
                                                                <input id="encerramento" type="text" name="encerramento"
                                                                       class="form-control datepicker" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-8">
                                                        <div class="form-group">
                                                            <label>Anexo do Contrato: <span
                                                                        class="text-size-mini text-danger">Somente arquivos PDF</span></label>
                                                            <input type="file" name="arquivo" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Objeto do Contrato: <span
                                                                        class="text-danger">*</span></label>
                                                    <textarea name="objeto" class="form-control" cols="30" rows="5"
                                                              required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <button type="submit" class="btn btn-primary"><i
                                                                    class="icon-database-check"></i>
                                                            Salvar
                                                        </button>
                                                        <input type="hidden" name="tipo" value="N">
                                                        <input type="hidden" name="contrato_id"
                                                               value="{{ $contrato->id }}">
                                                        <a href="{{ route('aditivos.index') }}"
                                                           class="btn btn-danger"><i
                                                                    class="icon-undo"></i>
                                                            Voltar</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- FIM DO CONTEUDO DO TAB 1 -->

                                        <!-- CONTEUDO DO TAB 2 -->
                                        <div class="tab-pane has-padding" id="bordered-justified-tab2">
                                            <fieldset>
                                                <legend>Dados originais do Contrato</legend>
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Numero / Ano:</label>
                                                            <input type="text" class="form-control"
                                                                   value="{{ $contrato->numero }}/{{ $contrato->orig_ano }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Inicio:</label>
                                                            <input type="text" class="form-control"
                                                                   value="{{ $contrato->orig_inicio  }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Encerramento:</label>
                                                            <input type="text" class="form-control"
                                                                   value="{{ $contrato->orig_encerramento  }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Total:</label>
                                                            <input type="text" class="form-control"
                                                                   value="R$ {{ number_format($contrato->orig_total, 2, ',', '.') }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Mensal:</label>
                                                            <input type="text" class="form-control"
                                                                   value="R$ {{ number_format($contrato->orig_mensal, 2, ',', '.') }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <div class="form-group">
                                                            <label>Casa:</label>
                                                            <input type="text" class="form-control"
                                                                   value="{{ $contrato->casa->name }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    @if(!empty($contrato->unidade_id))
                                                        <div class="col-xs-3">
                                                            <div class="form-group">
                                                                <label>Casa:</label>
                                                                <input type="text" class="form-control"
                                                                       value="{{ $contrato->unidade->name }}" disabled>
                                                            </div>
                                                        </div>

                                                    @endif
                                                    <div class="col-xs-7">
                                                        <div class="form-group">
                                                            <label>Contratado:</label><br>
                                                            <input type="text"
                                                                   value="@foreach($contrato->empresas as $empresa){{ $empresa->razao }}, @endforeach"
                                                                   class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Listagem de Aditivos</legend>
                                                <table class="table table-bordered table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th>Aditivo</th>
                                                        <th>Ano</th>
                                                        <th>Inicio</th>
                                                        <th>Fim</th>
                                                        <th>Total</th>
                                                        <th>Termo Aditivo</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($contrato->aditivos->count() < 1)
                                                        <tr>
                                                            <td colspan="6" class="text-center">Contrato sem aditivos cadastrados</td>
                                                        </tr>
                                                    @else
                                                        @foreach($contrato->aditivos as $aditivo)
                                                            <tr>
                                                                <td>{{ $aditivo->aditivos }}</td>
                                                                <td>{{ $aditivo->ano }}</td>
                                                                <td>{{ $aditivo->inicio }}</td>
                                                                <td>{{ $aditivo->encerramento }}</td>
                                                                <td>
                                                                    R$ {{ number_format($aditivo->total, 2, ',', '.') }}
                                                                </td>
                                                                <td>
                                                                    <a href="{{ url('/uploads/files') }}/{{ $contrato->arquivo }}"
                                                                       target="_blank"><i
                                                                                class="icon-search4"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </fieldset>
                                        </div>
                                        <!-- FIM DO CONTEUDO DO TAB 2 -->
                                    </div>
                                </div>
                            @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@stop