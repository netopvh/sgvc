@extends('layouts.master')
@section('scripts-before')
    <script src="{{ asset('public/assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/forms/mask/jquery-maskmoney/src/jquery.maskMoney.js') }}"></script>
    <script src="{{ asset('public/assets/js/modules/contratos.js') }}"></script>
@stop
@section('content')
    {!! Breadcrumbs::render('contratos.normal') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Cadastrar Contrato</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('contratos.normal.update',['id' => $contrato->id]) }}"
                              class="form-validate" id="formContrato" method="post"
                              autocomplete="off" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                                    <!-- Inicio do Form -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Número do Contrato: <span class="text-danger">*</span></label>
                                        <input type="text" name="numero" value="{{ $contrato->numero }}"
                                               class="form-control"
                                               required autofocus>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>Ano: <span class="text-danger">*</span></label>
                                        <input type="text" name="ano" value="{{ $contrato->ano }}" id="numbers"
                                               class="form-control" maxlength="4"
                                               required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Contratante: <span class="text-danger">*</span></label>
                                        <select name="casa_id" id="casa" class="select" required>
                                            <option value="">Selecione</option>
                                            @foreach($casas as $casa)
                                                <option value="{{ $casa->id }}"{{ $casa->id == $contrato->casa_id?' selected':'' }}>{{ $casa->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Unidade Operacional:</label>
                                        <select name="unidade_id" class="select">
                                            <option value=""></option>
                                            @foreach($unidades as $unidade)
                                                <option value="{{ $unidade->id }}" {{ $unidade->id == $contrato->unidade_id ?' selected':'' }}>{{ $unidade->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Âmbito: <span class="text-danger">*</span></label>
                                        <select name="ambito" class="select" required>
                                            <option value="">Selecione</option>
                                            <option value="M"{{ $contrato->ambito == 'M'?' selected':'' }}>Municipal
                                            </option>
                                            <option value="E"{{ $contrato->ambito == 'E'?' selected':'' }}>Estadual
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Gestores do Contrato: <span class="text-danger">*</span></label>
                                        <select name="gestores[]" class="select-multiple" multiple="multiple"
                                                required>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"{{ in_array($user->id, $gestores) ? ' selected="selected"' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Fiscais do Contrato: <span class="text-danger">*</span></label>
                                        <select name="fiscais[]" class="select-multiple" multiple="multiple"
                                                required>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"{{ in_array($user->id, $fiscais) ? ' selected="selected"' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Total do Contrato: <span class="text-danger">*</span></label>
                                        <input type="text" name="total" value="{{ $contrato->total }}" id="total"
                                               class="form-control"
                                               data-prefix="R$ " data-thousands="." data-decimal="," required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Valor Mensal do Contrato:</label>
                                        <input type="text" name="mensal" value="{{ $contrato->mensal }}" id="mensal"
                                               class="form-control"
                                               data-prefix="R$ " data-thousands="." data-decimal=",">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Início do Contrato: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                            <input type="text" name="inicio" value="{{ $contrato->inicio }}"
                                                   class="form-control datepicker" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Fim do Contrato: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                            <input type="text" name="encerramento" value="{{ $contrato->encerramento }}"
                                                   class="form-control datepicker"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Contratado: <span class="text-danger">*</span></label>
                                        <select name="empresas[]" class="select-multiple" multiple required>
                                            @foreach($empresas as $empresa)
                                                <option value="{{ $empresa->id }}"{{ in_array($empresa->id, $empresas_field) ? ' selected="selected"' : '' }}>
                                                    @if(strlen($empresa->cpf_cnpj) == 14)
                                                        {{ mask('##.###.###/####-##', $empresa->cpf_cnpj) }}
                                                    @else
                                                        {{ mask('###.###.###-##', $empresa->cpf_cnpj) }}
                                                    @endif
                                                    - {{ $empresa->razao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Anexo do Contrato: <span class="text-size-mini text-danger">Somente arquivos PDF</span></label>
                                        <input type="file" name="arquivo" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Objeto do Contrato: <span class="text-danger">*</span></label>
                                        <textarea name="objeto" class="form-control" cols="30" rows="5"
                                                  required>{{ $contrato->objeto }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Fim do Form -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" id="button" class="btn btn-primary"><i class="icon-database-check"></i>
                                        Salvar
                                    </button>
                                    <input type="hidden" name="tipo" value="N">
                                    <a href="{{ route('contratos.index') }}" class="btn btn-danger"><i
                                                class="icon-undo"></i>
                                        Voltar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop