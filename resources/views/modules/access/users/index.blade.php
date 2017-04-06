@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('users.index') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-10">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Usuários</h5>

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
                    <form action="{{ route('users.index') }}" method="get">

                        <div class="form-group">
                            <div class="col-lg-5">
                                <div class="input-group">
												<span class="input-group-btn">
													<button class="btn btn-default btn-icon" type="button"><i class="icon-user"></i></button>
												</span>
                                    <input type="text" class="form-control" placeholder="Digite o nome do Colaborador" name="search">
												<span class="input-group-btn">
													<button class="btn btn-default" type="submit">Pesquisar</button>
												</span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <ul class="icons-list">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="{{ route('users.edit', ['id' => $user->id]) }}"><i
                                                                class="icon-pencil7"></i> Editar</a></li>
                                                <li><a href="#"><i class="icon-folder-search"></i> Ver Informações</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@stop