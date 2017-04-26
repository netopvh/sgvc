@extends('layouts.master')
@section('scripts-after')
    <script type="text/javascript" src="{{ asset('public/assets/js/modules/roles.js') }}"></script>
@stop

@section('content')
    {!! Breadcrumbs::render('roles.create') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Cadastrar Perfil de Acesso</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('roles.store') }}" class="form-validate-jquery" method="post"
                              autocomplete="off">
                            {{ csrf_field() }}
                            <!-- Inicio do Form -->
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <input type="text" name="name" id="name"
                                               value="" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label>Permissões</label>
                                        <select name="associated-permissions" class="select">
                                            <option value="all">Todas</option>
                                            <option value="custom">Personalizado</option>
                                        </select>
                                        <div id="available-permissions" class="hidden mt-20">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    @if($permissions->count())
                                                        @foreach($permissions as $perm)
                                                            <input type="checkbox" name="permissions[{{ $perm->id }}]"
                                                                   value="{{ $perm->id }}"
                                                                   id="perm_{{ $perm->id }}" {{ is_array(old('permissions')) && in_array($perm->id, old('permissions')) ? 'checked' : '' }} />
                                                            <label for="perm_{{ $perm->id }}">{{ $perm->display_name }}</label>
                                                            <br/>
                                                        @endforeach
                                                    @else
                                                        <p>Não existem permissões disponíveis.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label>Ordem</label>
                                        <input type="text" name="sort" value="{{ $role_count+1 }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- Fim do Form -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary"><i class="icon-database-check"></i>
                                        Salvar
                                    </button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-danger"><i class="icon-undo"></i>
                                        Voltar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
@stop