@extends('layouts.master')

@section('page-header')
    Control de estudiantes
@endsection

@push('customcss')
    @include('layouts.datatablecss')
    <link href="{{ asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <!-- Alertify -->
		<link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/alertifyjs/css/alertify.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/alertifyjs/css/themes/bootstrap.min.css') }}">

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

        .alertify .ajs-dialog {
            border-radius: 1px !important;
            font-size: 12px;
            max-width: 320px !important;
            border: 2px solid black !important;
        }

        .alertify .ajs-header {
            display: none !important;
        }

        .ajs-commands {
            display: none !important;
        }

        .alertify .ajs-footer {
            border-top: none !important;
        }

        .alertify .ajs-dialog {
            margin: 3% auto !important;
        }

        .ajs-primary.ajs-buttons {
            margin-right: 30px !important;
        }

        .ajs-button {
            background: rgb(0, 81, 255);
            border-color: rgb(0, 81, 255);
            color: white;
        }

        .alertify .ajs-body {
            text-align: justify !important;
        }
    </style>
@endpush

@push('customjs')
    @include('layouts.datatablejs')
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
    <!-- Alertify -->
	<script src="{{ asset('/assets/plugins/alertifyjs/alertify.min.js') }}"></script>
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
            
            $('#myform').on('click', '#search', function(e) {
                e.preventDefault();
                let start_date           = getValue("start_date");
                let end_date             = getValue("end_date");

                if((valIsEmpty(start_date) && valIsEmpty(end_date)) || (!valIsEmpty(start_date) && !valIsEmpty(end_date))) {
                    if(convert_date(start_date) <= convert_date(end_date)) {
                        tabla.draw();
                    } else {
                        showAlertify('La fecha inicial debe ser menor o igual a fecha final.');
                    }
                } else {
                    showAlertify('La fecha inicial requiere la fecha final y viceversa.');
                }
            });
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
                    url : '{{ route('control_estudiantes.data') }}',
                    type: "POST",
                    data: function ( d ) {
                        d.name           = getValue("name");
                        d.paterno        = getValue("paterno");
                        d.materno        = getValue("materno");
                        d.cuip           = getValue("cuip");
                        d.type           = valIsEmpty($("#type option:selected").val()) ? "" : $("#type option:selected").val();
                        d.course         = getValue("course");
                        d.start_date     = getValue("start_date");
                        d.end_date       = getValue("end_date");
                        d.corporation    = valIsEmpty($("#corporation option:selected").val()) ? "" : $("#corporation option:selected").val();
                        d.classification = valIsEmpty($("#classification option:selected").val()) ? "" : $("#classification option:selected").val();
                        d.status         = valIsEmpty($("#status option:selected").val()) ? "" : $("#status option:selected").val();
                        d._token         = "{{ csrf_token() }}";
                    },
                    dataSrc: function(datos) {
                        setValue("name_search", getValue("name"));
                        setValue("paterno_search", getValue("paterno"));
                        setValue("materno_search", getValue("materno"));
                        setValue("cuip_search", getValue("cuip"));
                        setValue("type_search", getValue("type"));
                        setValue("course_search", getValue("course"));
                        setValue("start_date_search", getValue("start_date"));
                        setValue("end_date_search", getValue("end_date"));
                        setValue("corporation_search", getValue("corporation"));
                        setValue("classification_search", getValue("classification"));
                        setValue("status_search", getValue("status"));

                        return datos.data;
                    },
                    error: function (xhr, error, thrown) {
                        showAlertify('Error en el proceso.');
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'classification', name: 'classification' },
                    { data: 'corporation', name: 'corporation' },
                    { data: 'cuip', name: 'cuip' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'type', name: 'type' },
                    { data: 'status', name: 'status' },
                    { data: 'scores', name: 'scores', className: 'text-center' },
                    { data: 'students', name: 'students' },
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
                        <button id="search" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>

            <input type="hidden" id="name_search" name="name_search" value="" />
            <input type="hidden" id="paterno_search" name="paterno_search" value="" />
            <input type="hidden" id="materno_search" name="materno_search" value="" />
            <input type="hidden" id="cuip_search" name="cuip_search" value="" />
            <input type="hidden" id="type_search" name="type_search" value="" />
            <input type="hidden" id="course_search" name="course_search" value="" />
            <input type="hidden" id="start_date_search" name="start_date_search" value="" />
            <input type="hidden" id="end_date_search" name="end_date_search" value="" />
            <input type="hidden" id="corporation_search" name="corporation_search" value="" />
            <input type="hidden" id="classification_search" name="classification_search" value="" />
            <input type="hidden" id="status_search" name="status_search" value="" />
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