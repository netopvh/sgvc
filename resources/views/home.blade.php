@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('home') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="icon-clipboard2"></i> <span class="text-size-large">Sistema de Gestão e Vigência de Contratos</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th width="130">Numero/Ano</th>
                                <th width="100">Contratante</th>
                                <th>Contratado</th>
                                <th width="120">Aditivado?</th>
                                <th>Fim do Contrato</th>
                                <th width="40">Visualizar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($contratos->count() >= 1)
                                @foreach($contratos as $contrato)
                                    @if(user_all() == true || in_array($user, $contrato->gestores->pluck('id')->toArray()) || in_array($user, $contrato->fiscais->pluck('id')->toArray()))
                                        <tr class="bg-danger-800">
                                            <td>
                                                @if($contrato->aditivado == 'S')
                                                    {{ $contrato->orig_numero_ano }}
                                                @else
                                                    {{ $contrato->numero_ano }}
                                                @endif
                                            </td>
                                            <td>{{ $contrato->casa->name }}</td>
                                            <td>
                                                @if(count($contrato->empresas) > 1)
                                                    @foreach($contrato->empresas as $empresa)
                                                        {{ $empresa->razao }}<b>.</b>
                                                    @endforeach
                                                @else
                                                    @foreach($contrato->empresas as $empresa)
                                                        {{ $empresa->razao }}<b>.</b>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if($contrato->aditivado == 'N')
                                                    <span class="label label-info">Não</span>
                                                @elseif($contrato->aditivado == 'S')
                                                    <span class="label label-success">Sim</span>
                                                @endif
                                            </td>
                                            <td>{{ $contrato->encerramento }}</td>
                                            <td class="text-center"><a
                                                        href="{{ route('contratos.view',['id' => $contrato->id]) }}"
                                                        class="btn btn-sm btn-primary"><i
                                                            class="icon-eye"></i></a></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Sem contratos Próximo do Vencimento!</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Sem contratos Próximo do Vencimento!</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
