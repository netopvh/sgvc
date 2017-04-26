@extends('layouts.master')

@section('styles-before')
    <style>

        .stack {
            font-size: 0.85em;
        }
        .date {
            min-width: 75px;
        }
        .text {
            word-break: break-all;
        }
        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }
        </style>
@stop

@section('scripts-after')
    <script src="{{ asset('public/assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table-log').DataTable({
                "order": [1, 'desc'],
                "stateSave": true,
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                },
                "stateSaveCallback": function (settings, data) {
                    window.localStorage.setItem("datatable", JSON.stringify(data));
                },
                "stateLoadCallback": function (settings) {
                    var data = JSON.parse(window.localStorage.getItem("datatable"));
                    if (data) data.start = 0;
                    return data;
                }
            });
            $('.table-container').on('click', '.expand', function () {
                $('#' + $(this).data('display')).toggle();
            });
            $('#delete-log, #delete-all-log').click(function () {
                return confirm('Are you sure?');
            });
        });
        // Enable Select2 select for the length option
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    </script>
@stop
@section('content')
    {!! Breadcrumbs::render('logs.index') !!}
    <br>
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Logs do Sistema</h5>

                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-2 col-md-2">
                                <h4><span class="icon-calendar22" aria-hidden="true"></span> Todos</h4>
                                <div class="list-group">
                                    @foreach($files as $file)
                                        <a href="?l={{ base64_encode($file) }}"
                                           class="list-group-item @if ($current_file == $file) llv-active @endif">
                                            {{$file}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-10">
                                @if ($logs === null)
                                    <div>
                                        Log file >50M, please download it.
                                    </div>
                                @else
                                    <table id="table-log" class="table table-striped small">
                                        <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Contexto</th>
                                            <th>Data</th>
                                            <th>Informação</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($logs as $key => $log)
                                            <tr>
                                                <td class="text-{{ $log['level_class']}}"><span
                                                            class="icon-{{ $log['level_img'] }}"
                                                            aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
                                                <td class="text">{{ $log['context'] }}</td>
                                                <td class="date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$log['date'])->format('d/m/Y H:i') }}</td>
                                                <td class="text">
                                                    @if ($log['stack']) <a
                                                            class="pull-right expand btn btn-default btn-xs"
                                                            data-display="stack{{ $key }}"><span
                                                                class="icon-search4"></span></a>@endif
                                                    {{ $log['text'] }}
                                                    @if (isset($log['in_file'])) <br/>{{ $log['in_file'] }}@endif
                                                    @if ($log['stack'])
                                                        <div class="stack" id="stack{{ $key}}"
                                                             style="display: none; white-space: pre-wrap;">{{  trim($log['stack'])  }}</div>@endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                @endif
                                <div>
                                    @if($current_file)
                                        <a href="?dl={{ base64_encode($current_file) }}"><span
                                                    class="icon-download"></span> Baixar Arquivo</a>
                                        -
                                        <a id="delete-log" href="?del={{ base64_encode($current_file) }}"><span
                                                    class="icon-bin2"></span> Deletar Arquivo</a>
                                        @if(count($files) > 1)
                                            -
                                            <a id="delete-all-log" href="?delall=true"><span
                                                        class="icon-folder-remove"></span> Deletar Todos os
                                                Arquivos</a>
                                        @endif
                                    @endif
                                </div>
                                    <br>
                                    <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>

