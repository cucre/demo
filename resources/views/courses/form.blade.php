@extends('layouts.master')

@section('page-header')
    Gestor de cursos
@endsection

@push('customcss')
    <link href="{{ asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <style type="text/css">
        .readonly {
            box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
            background: transparent !important;
        }
    </style>
@endpush

@push('customjs')
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2({
                placeholder: "Selecciona",
                allowClear: true,
                language: 'es'
            });
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

            $(`#myform`).find(`input[name='name']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='hours']`).classOnlyIntegers().classMaxCharacters(2);
        });
    </script>
@endpush

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $action == 'create' ? 'Registrar' : 'Editar' }} curso</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create' ? route('cursos.store') : route('cursos.update', $curso->id) }}" method="post" id="myform">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-3">
                        <label class="label-control">Nombre del curso <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $curso->name ?? "") }}">
                        {!! $errors->first('name', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">Clasificación <span class="text-danger">*</span></label>
                        <select id="classification" class="form-control select2" name="classification">
                            <option value=""></option>
                            <option value="Formación inicial" {{ old('classification', $curso->classification ?? "") == "Formación inicial" ? 'selected' : '' }}>Formación inicial</option>
                        </select>
                        {!! $errors->first('classification', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">Total de horas <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="hours" name="hours" value="{{ old('hours', $curso->hours ?? "") }}">
                        {!! $errors->first('hours', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">&nbsp;</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="without_evaluation" id="without_evaluation" @if(old('without_evaluation', $curso->without_evaluation ? true : false)) checked @endif>
                            <label class="form-check-label" for="without_evaluation">
                                Impartir curso sin evaluacion
                            </label>
                            {!! $errors->first('without_evaluation', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="label-control">Fecha inicio <span class="text-danger">*</span></label>
                        <input class="form-control readonly" type="text" id="start_date" name="start_date" value="{{ old('start_date', $curso->start_date ?? "") }}" readonly>
                        {!! $errors->first('start_date', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">Fecha fin <span class="text-danger">*</span></label>
                        <input class="form-control readonly" type="text" id="end_date" name="end_date" value="{{ old('end_date', $curso->end_date ?? "") }}" readonly>
                        {!! $errors->first('end_date', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-6">
                        <label class="label-control">Materias <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="subjects[]" multiple>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" @if(in_array($subject->id, old('subjects', $curso->subjects->pluck('id')->toArray()))) selected @endif>
                                    {{ $subject->subject ?? "" }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('subjects', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create' ? 'Registrar' : 'Actualizar' }}
                        </button>
                        <a href="{{ route('cursos.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection