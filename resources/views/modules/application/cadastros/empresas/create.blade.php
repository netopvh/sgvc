@extends('layouts.master')
@section('scripts-before')
    <script src="{{ asset('assets/js/plugins/forms/mask/dist/inputmask/inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/mask/dist/inputmask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/modules/empresas.js') }}"></script>
@stop
@section('content')
    {!! Breadcrumbs::render('empresas.create') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Cadastrar Contratado</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('empresas.store') }}" class="form-validate-jquery" method="post"
                              autocomplete="off">
                            {{ csrf_field() }}
                                    <!-- Inicio do Form -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Razão Social</label>
                                        <input type="text" name="razao" id="razao" class="form-control upper"
                                               required autofocus>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nome Fantasia</label>
                                        <input type="text" name="fantasia" id="fantasia" class="form-control upper">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Tipo Pessoa</label>
                                        <select name="tipo_pessoa" id="tipo" class="select" required>
                                            <option value="">Selecione</option>
                                            @foreach($tipo_pessoa as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CPF/CNPJ</label>
                                        <input type="text" name="cpf_cnpj" id="cnpj" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Responsável</label>
                                        <input type="text" name="responsavel" class="form-control"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <!-- Fim do Form -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary"><i class="icon-database-check"></i>
                                        Salvar
                                    </button>
                                    <a href="{{ route('empresas.index') }}" class="btn btn-danger"><i
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