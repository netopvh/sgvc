@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('empresas.index') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-10">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Contratados</h5>

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
                        <a href="{{ route('empresas.create') }}" class="btn btn-primary"><i class="icon-plus-circle2"></i> Cadastrar</a>
                    </div>
                    <div class="table-responsive">
                        <form action="{{ route('empresas.index') }}" method="get">

                            <div class="form-group">
                                <div class="col-lg-5">
                                    <div class="input-group">
												<span class="input-group-btn">
													<button class="btn btn-default btn-icon" type="button"><i class="icon-user"></i></button>
												</span>
                                        <input type="text" class="form-control" placeholder="Digite a Razão ou CPF/CNPJ sem pontos" name="search">
												<span class="input-group-btn">
													<button class="btn btn-default" type="submit">Pesquisar</button>
												</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br><br>
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th width="70">ID</th>
                                <th>Razão Social</th>
                                <th width="230">CPF / CNPJ</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-center" width="80">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($empresas as $empresa)
                                <tr>
                                    <td>{{ $empresa->id }}</td>
                                    <td>{{ $empresa->razao }}</td>
                                    <td>
                                        @if(strlen($empresa->cpf_cnpj) == 14)
                                            {{ mask('##.###.###/####-##', $empresa->cpf_cnpj) }}
                                        @else
                                            {{ mask('###.###.###-##', $empresa->cpf_cnpj) }}
                                        @endif
                                    </td>
                                    <td>{{ $empresa->email }}</td>
                                    <td>{{ $status[$empresa->status] }}</td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('empresas.edit', ['id' => $empresa->id]) }}"><i class="icon-pencil7"></i> Editar</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">{{ $empresas->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@stop