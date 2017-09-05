@extends('layouts.master')
@section('scripts-after')
    <script src="{{ asset('assets/js/modules/roles.js') }}"></script>
@stop

@section('content')
    {!! Breadcrumbs::render('roles.edit') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Editar Perfil de Acesso</h5>

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
                        <form action="{{ route('roles.update', ['id' => $role->id]) }}" class="form-validate-jquery"
                              method="post"
                              autocomplete="off">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                                    <!-- Inicio do Form -->
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <input type="text" name="name" id="name"
                                               value="{{ $role->name }}" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label>Permissões</label>
                                        <select name="associated-permissions" class="select">
                                            <option value="all" {{ $role->all == true ? 'selected':'' }}>Todas</option>
                                            <option value="custom" {{ $role->all == false ? 'selected':'' }}>
                                                Personalizado
                                            </option>
                                        </select>
                                        <div id="available-permissions" class="{{ $role->all == false ? '':'hidden' }} mt-20">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    @if($permissions->count())
                                                        @foreach($permissions as $perm)
                                                            <input type="checkbox" name="permissions[{{ $perm->id }}]"
                                                                   value="{{ $perm->id }}"
                                                                   id="perm_{{ $perm->id }}" {{ is_array(old('permissions')) ? (in_array($perm->id, old('permissions')) ? 'checked' : '') : (in_array($perm->id, $role_permissions) ? 'checked' : '') }} />
                                                            <label>{{ $perm->display_name }}</label>
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
                                        <input type="text" name="sort" value="{{ $role->sort }}" class="form-control">
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