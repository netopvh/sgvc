@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('home') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Fechar</span></button>
                                <span class="text-semibold"><i class="icon-alert"></i> Atenção! </span>Você não tem permissão para acessar esta área.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop