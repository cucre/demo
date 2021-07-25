@extends('layouts.master')

@section('page-header')
    Control de estudiantes
@endsection

@push('customcss')
    @include('layouts.datatablecss')
    <link href="{{ asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <style type="text/css">
        .readonly {
            box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
            background: transparent !important;
        }
        s
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
            $('#start_date').datepicker({
                language: "es",
                clearBtn: true,
                multidate: false,
                format: "dd/mm/yyyy",
                startDate: "-70y",
                orientation: "bottom",
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                let minDate = new Date(selected.date.valueOf());
                $('#end_date').datepicker('setStartDate', minDate);
            });
            $('#end_date').datepicker({
                language: "es",
                clearBtn: true,
                multidate: false,
                format: "dd/mm/yyyy",
                startDate: "-70y",
                orientation: "bottom",
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                let maxDate = new Date(selected.date.valueOf());
                $('#start_date').datepicker('setEndDate', maxDate);
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

            $(`#myform`).find(`input[name='name']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='paterno']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='materno']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='cuip']`).classMaxCharacters(20);
        });
    </script>
    <script>
        let tabla;

        $(function() {
            tabla = $('#tabla').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                order: [],
                deferLoading: 0,
                ajax: {
                url : '{{ route('control_estudiantes.index') }}',
                    data: function ( d ) {
                        d.num_exp    = getValue("numero_expediente");
                        d.tip_amp    = valIsEmpty($("#tipo_amparo option:selected").val()) ? "": $("#tipo_amparo option:selected").val();
                        d.sala       = valIsEmpty($("#sala option:selected").val()) ? "": $("#sala option:selected").val();
                        d.f_ini_amp  = getValue("fecha_inicial_amparo");
                        d.f_fin_amp  = getValue("fecha_final_amparo");
                        d.f_ini_res  = getValue("fecha_inicial_resolucion");
                        d.f_fin_res  = getValue("fecha_final_resolucion");
                        d._token     = getToken();
                    },
                    dataSrc: function(datos) {
                        setValue("numero_expediente_search", getValue("numero_expediente"));
                        setValue("tipo_amparo_search", getValue("tipo_amparo"));
                        setValue("sala_search", getValue("sala"));
                        setValue("fecha_inicial_amparo_search", getValue("fecha_inicial_amparo"));
                        setValue("fecha_final_amparo_search", getValue("fecha_final_amparo"));
                        setValue("fecha_inicial_resolucion_search", getValue("fecha_inicial_resolucion"));
                        setValue("fecha_final_resolucion_search", getValue("fecha_final_resolucion"));

                        return datos.data;
                    },
                    error: function (xhr, error, thrown) {
                        showAlertify('Error en el proceso.');
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'cuip', name: 'cuip' },
                    { data: 'name', name: 'name' },
                    { data: 'curp', name: 'curp' },
                    { data: 'corporation', name: 'corporation' },
                    { data: 'type', name: 'type' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'accion', name: 'accion', className: 'text-center', searchable: false },
                    { data: 'status', name: 'status' },
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
    </script>
@endpush


@section('content')
    <div class="panel">
        <div class="panel-body">
            <form id="myform">
                <div class="row">
                    <div class="col-lg-3">
                        <label class="label-control">Nombre</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">Primer apellido</label>
                        <input class="form-control" type="text" id="paterno" name="paterno" value="{{ old('paterno') }}">
                    </div>
                    <div class="col-lg-2">
                        <label class="label-control">Segundo apellido</label>
                        <input class="form-control" type="text" id="materno" name="materno" value="{{ old('materno') }}">
                    </div>
                    <div class="col-lg-2">
                        <label class="label-control">CUIP</label>
                        <input class="form-control" type="text" id="cuip" name="cuip" value="{{ old('cuip') }}">
                    </div>
                    <div class="col-lg-2">
                        <label class="label-control">Aspirante/Activo</label>
                        <select class="form-select select2" id="type" name="type" style="text-align: left;">
                            <option value=""></option>
                            @foreach($student_status as $status)
                                <option value="{{ $status->id }}">
                                    {{ $status->name ?? "" }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-8">
                        <label class="label-control">Nombre del curso</label>
                        <select class="form-select select2" id="course" name="course" style="text-align: left;">
                            <option value=""></option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">
                                    {{ $course->name ?? "" }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="label-control">Fecha inicio</label>
                        <input class="form-control readonly datepicker" type="text" id="start_date" name="start_date" value="{{ old('start_date') }}" readonly>
                    </div>
                    <div class="col-lg-2">
                        <label class="label-control">Fecha fin</label>
                        <input class="form-control readonly datepicker" type="text" id="end_date" name="end_date" value="{{ old('end_date') }}" readonly>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-8">
                        <label class="label-control">Corporación</label>
                        <select class="form-select select2" id="corporation" name="corporation" style="text-align: left;">
                            <option value=""></option>
                            @foreach($corporations as $corporation)
                                <option value="{{ $corporation->id }}">
                                    {{ $corporation->corporation ?? "" }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="label-control">Clasificación</label>
                        <select class="form-select select2" id="classification" name="classification" style="text-align: left;">
                            <option value=""></option>
                            <option value="Formación inicial" {{ old('classification') == "Formación inicial" ? 'selected' : '' }}>Formación inicial</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="label-control">Estatus</label>
                        <select class="form-select select2" id="status" name="status" style="text-align: left;">
                            <option value=""></option>
                            <option value="1" {{ old('status') == "1" ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('status') == "0" ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel">
        <div class="panel-body">
            <div class="table-responsive">
                <table width="100%" class="table table-striped" id="tabla">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 10%;">Nombre del curso</th>
                            <th style="width: 10%;">Clasificación</th>
                            <th style="width: 10%;">Corporación</th>
                            <th style="width: 10%;">CUIP</th>
                            <th style="width: 15%;">Nombre del estudiante</th>
                            <th style="width: 10%;">Activo/Aspirante</th>
                            <th style="width: 10%;">Estatus</th>
                            <th style="width: 10%;">Calificaciones</th>
                            <th style="width: 10%;">Registro</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection