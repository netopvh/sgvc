@extends('layouts.master')
@section('scripts-before')
    <script src="{{ asset('assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/modules/contratos.js') }}"></script>
@stop
@section('content')
    {!! Breadcrumbs::render('contratos.index') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Contratos</h5>

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
                        <a href="{{ route('contratos.create') }}" class="btn btn-primary"><i
                                    class="icon-plus-circle2"></i>
                            Cadastrar</a>
                        @if(Entrust::can('manage-aditivos') || user_role() == true)
                            <a href="{{ route('aditivos.index') }}" class="btn btn-primary"><i
                                        class="icon-clipboard2"></i>
                                Aditivar Contrato</a>
                        @endif
                        <a href="{{ route('contratos.excel') }}" class="btn btn-primary"><i
                                    class="icon-file-excel"></i>
                            Exportar Excel</a>
                        <fieldset>
                            <legend>Pesquisa Contrato</legend>
                            @include('modules.application.contratos.search')
                        </fieldset>
                    </div>
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th width="130">Número/Ano</th>
                            <th>Contratado</th>
                            <th>Contratante</th>
                            <th>Unidade / Setor</th>
                            <th>Vencimento</th>
                            <th width="50">Status</th>
                            <th width="40">Aditivado?</th>
                            <th class="text-center" width="80">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contratos as $contrato)
                            <!-- Verifica se o usuário pode visualizar o contrato -->
                            @if(user_all() == true || in_array($user, $contrato->gestores->pluck('id')->toArray()) || in_array($user, $contrato->fiscais->pluck('id')->toArray()))
                                <tr>
                                    <td>
                                        @if($contrato->aditivado == 'S')
                                            {{ $contrato->orig_numero_ano }}
                                        @else
                                            {{ $contrato->numero_ano }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(count($contrato->empresas) > 1)
                                            @foreach($contrato->empresas as $empresa)
                                                {{ $empresa->razao }}<b>.</b>
                                            @endforeach
                                        @else
                                            @foreach($contrato->empresas as $empresa)
                                                {{ $empresa->razao }}<b>.</b>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $contrato->casa->name }}</td>
                                    <td>{{ isset($contrato->unidade->name)?$contrato->unidade->name:'Unidade não cadastrada' }}</td>
                                    <td>{{ $contrato->encerramento }}</td>
                                    <td>
                                        @if($contrato->status == 'V')
                                            <span class="label label-success">Vigente</span>
                                        @elseif($contrato->status == 'C')
                                            <span class="label label-danger">Cancelado</span>
                                        @elseif($contrato->status == 'F')
                                            <span class="label label-info">Finalizado</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($contrato->aditivado == 'N')
                                            <span class="label label-info">Não</span>
                                        @elseif($contrato->aditivado == 'S')
                                            <span class="label label-success">Sim</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('contratos.view',['id' => $contrato->id]) }}"><i
                                                                    class="icon-eye"></i> Visualizar</a></li>
                                                    @if(!empty($contrato->arquivo))
                                                        <li>
                                                            <a href="{{ url('uploads/files') }}/{{ $contrato->arquivo }}"
                                                               target="_blank"><i
                                                                        class="icon-file-text2"></i> Contrato</a></li>
                                                    @endif
                                                    @if($contrato->aditivado == 'S')
                                                        <li>
                                                            <a href="{{ url('uploads/files') }}/{{ $contrato->aditivos->last()->arquivo }}"
                                                               target="_blank"><i
                                                                        class="icon-file-plus2"></i> Termo Aditivo</a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="{{ route('contratos.normal.edit',['id' => $contrato->id]) }}"><i
                                                                    class="icon-pencil7"></i> Editar</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">{{ $contratos->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@stop