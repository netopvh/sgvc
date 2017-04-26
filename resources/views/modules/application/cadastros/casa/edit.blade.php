@extends('layouts.master')

@section('scripts-before')
    <script src="{{ asset('public/assets/js/modules/casas.js') }}"></script>
@stop

@section('content')
    {!! Breadcrumbs::render('casas.edit') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Editar Contratante</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('casas.update', ['id' => $casa->id]) }}" class="form-validate-jquery"
                              method="post"
                              autocomplete="off">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                                    <!-- Inicio do Form -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <input type="text" name="name" id="name"
                                               value="{{ $casa->name }}" class="form-control"
                                               required autofocus>
                                    </div>
                                </div>
                            </div>
                            <!-- Fim do Form -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary"><i class="icon-database-check"></i>
                                        Salvar
                                    </button>
                                    <a href="{{ route('casas.index') }}" class="btn btn-danger"><i
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