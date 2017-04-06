@extends('layouts.master')
@section('scripts-after')
    <script src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
@stop

@section('scripts-before')
    <script src="{{ asset('assets/js/modules/users.js') }}"></script>
@stop

@section('content')
    {!! Breadcrumbs::render('config.index') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-10">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Parâmetros do Sistema</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Conteudo -->

                </div>
            </div>
        </div>
    </div>
@stop