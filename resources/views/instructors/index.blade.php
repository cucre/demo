@extends('layouts.master')

@section('page-header')
    Gestor de instructores
@endsection

@push('customcss')
    @include('layouts.datatablecss')
    <link href="{{ asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <style type="text/css">
        textarea {
            resize: none;
            padding: 5px;
        }
    </style>
@endpush

@push('customjs')
    @include('layouts.datatablejs')
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').datepicker({
                language: "es",
                clearBtn: true,
                multidate: false,
                format: "dd/mm/yyyy",
                startDate: "-70y",
                orientation: "bottom",
                autoclose: true,
                todayHighlight: true
            });

            $(".select2").select2({
                placeholder: "Selecciona",
                width: "100%",
                allowClear: true,
                language: 'es'
            });

            $(".readonly").keydown(function(e){
                e.preventDefault();
            });

            $(`#modal-form`).find(`input[name='date_leave']`).classMaxCharacters(10).classOnlyIntegers('/');
        });
    </script>
    <script>
        let tabla;

        $(function() {
            tabla = $('#tabla').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: '{!! route('instructores.data') !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'cuip', name: 'cuip' },
                    { data: 'name', name: 'name' },
                    { data: 'curp', name: 'curp' },
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
            $("#instructor_name").text($(this).find('.instructor').val());
            $("#modal-form").prop('action', $(this).find('.action').val());
            $("#delModal").modal('show');
        });

        $(document).on('click', ".restaurar", function(){
            $("#instructor_name_res").text($(this).find('.instructor').val());
            $("#modal-form-res").prop('action', $(this).find('.action').val());
            $("#instructor_id").val($(this).find('.instructor_id').val());
            $("#resModal").modal('show');
        });
    </script>
@endpush


@section('content')
    <!-- Modal Delete -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModal" aria-hidden="true">
        <form id="modal-form" method="post" class="form-horizontal">
            @csrf
            {!! method_field('DELETE') !!}
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="delModalLabel">¿Eliminar instructor?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <i class="fas fa-exclamation-circle fa-5x text-danger"></i>
                                </div>
                                <div class="col-lg-12 text-center">
                                    ¿Estás seguro que quieres eliminar el instructor <strong id="instructor_name"></strong>?
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 offset-1">
                                <label class="label-control">Tipo de baja <span style="color: red;">*</span></label>
                                <select class="form-select select2" id="type_leave" name="type_leave" style="text-align: left;" required>
                                    <option value=""></option>
                                    <option value="1">Baja como instructor</option>
                                </select>
                                <br>
                            </div>
                            <div class="col-lg-5">
                                <label class="label-control">Fecha de baja <span style="color: red;">*</span></label>
                                <input class="form-control datepicker readonly" type="text" id="date_leave" name="date_leave" value="" required>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 offset-1">
                                <label class="label-control">Motivo de baja <span style="color: red;">*</span></label>
                                <textarea class="form-control" id="reason_leave" name="reason_leave" rows="3" required></textarea>
                                <br>
                            </div>
                        </div>
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
                    <h5 class="modal-title" id="delModalLabel">¿Restaurar instructor?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 text-center">
                            <i class="fas fa-exclamation-circle fa-5x text-warning"></i>
                        </div>
                        <div class="col-lg-12 text-center">
                            ¿Estás seguro que quieres restaurar el instructor <strong id="instructor_name_res"></strong>?
                        </div>
                        <input type="hidden" id="instructor_id" name="instructor_id" value="">
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
        {!! $errors->first('type_leave', '<small class="help-block text-danger">:message</small><br/>') !!}
        {!! $errors->first('date_leave', '<small class="help-block text-danger">:message</small><br/>') !!}
        {!! $errors->first('reason_leave', '<small class="help-block text-danger">:message</small><br/>') !!}
        <div class="panel-heading">
            <h4 class="panel-title">Instructores del sistema</h4>
            <div class="panel-heading-btn">
                @can('instructores.create')<a href="{{ route('instructores.create') }}" class="btn btn-indigo btn-sm"><i class="fas fa-user-plus"></i>&nbsp; Agregar instructor</a>&nbsp;&nbsp;&nbsp;&nbsp;@endcan
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
                            <th style="width: 10%;">CUIP</th>
                            <th style="width: 25%;">Nombre del instructor</th>
                            <th style="width: 10%;">CURP</th>
                            <th style="width: 10%;">Fecha de alta</th>
                            <th style="width: 10%;">Estatus</th>
                            <th style="width: 15%;">Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection