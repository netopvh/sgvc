@extends('layouts.master')
@section('scripts-before')
    <script src="{{ asset('assets/js/modules/unidades.js') }}"></script>
@stop
@section('content')
    {!! Breadcrumbs::render('unidades.create') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Criar Unidade / Setor</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('unidades.store') }}" class="form-validation" method="post"
                              autocomplete="off">
                            {{ csrf_field() }}
                                    <!-- Inicio do Form -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Casa</label>
                                        <select name="casa_id" class="select" required>
                                            <option value="">Selecione</option>
                                            @foreach($casas as $casa)
                                                <option value="{{ $casa->id }}">{{ $casa->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Fim do Form -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary"><i class="icon-database-check"></i>
                                        Salvar
                                    </button>
                                    <a href="{{ route('unidades.index') }}" class="btn btn-danger"><i
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