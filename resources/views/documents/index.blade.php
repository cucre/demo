@extends('layouts.master')

@section('page-header')
    @if(Request::route()->named('documentos.index'))
        @php($ruta = route('documentos.data', $id))
        @php($ruta_redirect = 'documentos.index')
        <div class="row">
            <a href="{{ route('instructores.index') }}" style="font-size: 14px;"><em class="fas fa-arrow-left"></em> Regresar </a>
        </div>

    @else
        @php($ruta = route('documentos_estudiantes.data', $id))
        @php($ruta_redirect = 'documentos_estudiantes.index')
        <div class="row">
            <a href="{{ route('estudiantes.index') }}" style="font-size: 14px;"><em class="fas fa-arrow-left"></em> Regresar </a>
        </div>
    @endif
    Gestor de documentos
@endsection

@push('customcss')
    @include('layouts.datatablecss')
@endpush

@push('customjs')
    @include('layouts.datatablejs')
    <script>
        let tabla;

        $(function() {
            tabla = $('#tabla').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: '{!! $ruta !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'path', name: 'path'},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'accion', name: 'accion', className: 'text-center', searchable: false },
                ],
                order: [[ 1, 'asc' ]],
                autoWidth: true,
                language    : {
                    url     :'{{ asset('/js/datatables/language/spanish.json') }}'
                },
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'excel',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'csv',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'pdf ',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    }
                ]
            });
        });

        $(document).on('click', ".eliminar", function(){
            $("#document_name").text($(this).find('.name').val());
            $("#id").val($(this).find('.id').val());
            $("#document_id").val($(this).find('.document_id').val());
            $("#modal-form").prop('action', $(this).find('.action').val());
            $("#delModal").modal('show');
        });

        $(document).on('click', ".restaurar", function(){
            $("#document_name_res").text($(this).find('.name').val());
            $("#id_res").val($(this).find('.id_res').val());
            $("#document_id_res").val($(this).find('.document_id_res').val());
            $("#modal-form-res").prop('action', $(this).find('.action').val());
            $("#resModal").modal('show');
        });
    </script>
@endpush


@section('content')
    <!-- Modal Delete -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModal" aria-hidden="true">
        <form id="modal-form" method="post">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="delModalLabel">¿Eliminar documento?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 text-center">
                            <i class="fas fa-exclamation-circle fa-5x text-danger"></i>
                        </div>
                        <div class="col-lg-12 text-center">
                            ¿Estás seguro que quieres eliminar el documento <strong id="document_name"></strong>?
                        </div>
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="document_id" name="document_id" value="">
                        <input type="hidden" id="ruta_redirect" name="ruta_redirect" value="{{ $ruta_redirect }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Restore -->
    <div class="modal fade" id="resModal" tabindex="-1" role="dialog" aria-labelledby="resModal" aria-hidden="true">
        <form id="modal-form-res" method="post">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="delModalLabel">¿Restaurar documento?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 text-center">
                            <i class="fas fa-exclamation-circle fa-5x text-warning"></i>
                        </div>
                        <div class="col-lg-12 text-center">
                            ¿Estás seguro que quieres restaurar el documento <strong id="document_name_res"></strong>?
                        </div>
                        <input type="hidden" id="id_res" name="id_res" value="">
                        <input type="hidden" id="document_id_res" name="document_id_res" value="">
                        <input type="hidden" id="ruta_redirect_res" name="ruta_redirect_res" value="{{ $ruta_redirect }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Restaurar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Documentos del sistema</h4>
            <div class="panel-heading-btn">
                @can('documentos.create')<a href="@if(Request::route()->named('documentos.index')) {{ route('documentos.create', $id) }} @else {{ route('documentos_estudiantes.create', $id) }} @endif" class="btn btn-indigo btn-sm"><i class="fas fa-user-plus"></i>&nbsp; Agregar documento</a>&nbsp;&nbsp;&nbsp;&nbsp;@endcan
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table width="100%" class="table table-striped" id="tabla">
                    <thead>
                        <tr>
                            <th style="width: 10%;">#</th>
                            <th style="width: 20%;">Nombre</th>
                            <th style="width: 20%;">Descripción</th>
                            <th style="width: 10%;">Documento</th>
                            <th style="width: 10%;">Fecha de alta</th>
                            <th style="width: 10%;">Estatus</th>
                            <th style="width: 20%;">Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection