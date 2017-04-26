@extends('layouts.master')
@section('scripts-before')
    <script src="{{ asset('public/assets/js/modules/casas.js') }}"></script>
@stop
@section('content')
    {!! Breadcrumbs::render('casas.index') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Contratantes</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
                    @if (notify()->ready())
                        <div class="alert alert-{{ notify()->type() }}">
                            {{ notify()->message() }}
                        </div>
                    @endif
                    <div class="container">
                        <a href="{{ route('casas.create') }}" class="btn btn-primary"><i class="icon-plus-circle2"></i> Cadastrar</a>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th width="70">ID</th>
                                <th>Nome</th>
                                <th class="text-center" width="80">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($casas as $casa)
                                <tr>
                                    <td>{{ $casa->id }}</td>
                                    <td>{{ $casa->name }}</td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('casas.edit', ['id' => $casa->id]) }}"><i class="icon-pencil7"></i> Editar</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop