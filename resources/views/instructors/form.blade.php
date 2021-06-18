@extends('layouts.master')

@section('page-header')
    Gestor de instructores
@endsection

@push('customcss')
    <link href="{{ asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <style type="text/css">
        .readonly {
            box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
            background: transparent !important;
        }

        textarea {
            resize: none;
            padding: 5px;
        }
    </style>
@endpush

@push('customjs')
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#birth_date').datepicker({
                language: "es",
                clearBtn: true,
                multidate: false,
                format: "dd/mm/yyyy",
                startDate: "-70y",
                endDate: "-18y",
                orientation: "bottom",
            });

            $(`#myform`).find(`input[name='name']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='paterno']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='materno']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='cuip']`).classMaxCharacters(20);
            $(`#myform`).find(`input[name='curp']`).classMaxCharacters(18).allToUpperCase();
            $(`#myform`).find(`input[name='birth_date']`).classOnlyIntegers('/');
            $(`#myform`).find(`input[name='telephone']`).classOnlyIntegers().classMaxCharacters(10);
            $(`#myform`).find(`input[name='email']`).classOnlyEmail().classMaxCharacters(255);
            $(`#myform`).find(`input[name='specialty']`).classMaxCharacters(255);
        });
    </script>
@endpush

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $action == 'create' ? 'Registrar' : 'Editar' }} instructor</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create' ? route('instructores.store') : route('instructores.update', $instructore->id) }}" method="post" id="myform">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-3">
                        <label class="label-control">Nombre <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $instructore->name ?? "") }}">
                        {!! $errors->first('name', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">Primer apellido <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="paterno" name="paterno" value="{{ old('paterno', $instructore->paterno ?? "") }}">
                        {!! $errors->first('paterno', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">Segundo apellido</label>
                        <input class="form-control" type="text" id="materno" name="materno" value="{{ old('materno', $instructore->materno ?? "") }}">
                        {!! $errors->first('materno', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">CUIP <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="cuip" name="cuip" value="{{ old('cuip', $instructore->cuip ?? "") }}">
                        {!! $errors->first('cuip', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="label-control">CURP <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="curp" name="curp" value="{{ old('curp', $instructore->curp ?? "") }}">
                        {!! $errors->first('curp', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">Fecha de nacimiento <span class="text-danger">*</span></label>
                        <input class="form-control readonly" type="text" id="birth_date" name="birth_date" value="{{ old('birth_date', $instructore->birth_date ?? "") }}" readonly>
                        {!! $errors->first('birth_date', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-6">
                        <label class="label-control">Dirección particular</label>
                        <input class="form-control" type="text" id="address" name="address" value="{{ old('address', $instructore->address ?? "") }}">
                        {!! $errors->first('address', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="label-control">Teléfono/celular <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="telephone" name="telephone" value="{{ old('telephone', $instructore->telephone ?? "") }}">
                        {!! $errors->first('telephone', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <label class="label-control">Correo electrónico <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="email" name="email" value="{{ old('email', $instructore->email ?? "") }}">
                        {!! $errors->first('email', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-6">
                        <label class="label-control">Especialidad</label>
                        <input class="form-control" type="text" id="specialty" name="specialty" value="{{ old('specialty', $instructore->specialty ?? "") }}">
                        {!! $errors->first('specialty', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label class="label-control">Certificaciones</label>
                        <textarea class="form-control" type="text" id="certifications" name="certifications" rows="5">{{ old('certifications', $instructore->certifications ?? "") }}</textarea>
                        {!! $errors->first('certifications', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label class="label-control">Observaciones</label>
                        <textarea class="form-control" type="text" id="observations" name="observations" rows="5">{{ old('observations', $instructore->observations ?? "") }}</textarea>
                        {!! $errors->first('observations', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create' ? 'Registrar' : 'Actualizar' }}
                        </button>
                        <a href="{{ route('instructores.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection