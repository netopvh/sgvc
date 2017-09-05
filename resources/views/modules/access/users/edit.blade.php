@extends('layouts.master')

@section('scripts-before')
    <script src="{{ asset('assets/js/modules/users.js') }}"></script>
@stop

@section('content')
    {!! Breadcrumbs::render('users.edit') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Editar Usuário</h5>

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

                    <div class="panel-body">
                        <form action="{{ route('users.update', ['id' => $user->id]) }}" class="form-validate-jquery" autocomplete="off"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col-lg-10">
                                    <span class="small text-bold">As Informações Pessoais são Somente Leitura é permitido apenas alterar Perfil.</span>
                                </div>
                                <br>
                                <br>
                                <div class="col-lg-12">
                                    <!-- Inicio do Form -->
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <label class="text-semibold">Nome Completo:</label>
                                                <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                                       readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="text-semibold">Usuário:</label>
                                                <input type="text" value="{{ $user->username }}"
                                                       class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <label class="text-semibold">Email:</label>
                                                <input type="email" value="{{ $user->email }}"
                                                       class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="text-semibold">Perfil:</label>
                                                <select name="role_id" id="role_id" class="select" required>
                                                    <option value="">Selecione</option>
                                                    @foreach($roles as $role)
                                                        <option {{ (isset($user) && $user->roles()->first()->id == $role->id ? 'selected': '') }}
                                                                value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="text-semibold">Ver Todos os Contratos</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="all" value="1" class="styled"{{ $user->all == 1? ' checked':'' }}>
                                                    Sim
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="all" value="0" class="styled"{{ $user->all == 0? ' checked':'' }}>
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fim do Form -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <button class="btn btn-primary" id="gravar" type="submit"><i class="icon-database-check"></i> Salvar</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="icon-undo"></i> Voltar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop