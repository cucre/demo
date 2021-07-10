@extends('layouts.master')

@section('page-header')
    Gestor de estudiantes
@endsection

@push('customcss')
    <link href="{{ asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <style type="text/css">
        .readonlyshow {
            box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
            background: transparent !important;
            border: 0;
        }

        .readonly {
            box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
            background: transparent !important;
        }

        caption { /* ADDED */
            caption-side: top;
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
            $(".select2").select2({
                placeholder: "Selecciona",
                width: "100%",
                allowClear: true,
                language: 'es'
            });
            $('.datepicker').datepicker({
                language: "es",
                clearBtn: true,
                multidate: false,
                format: "dd/mm/yyyy",
                startDate: "-70y",
                endDate: "-18y",
                orientation: "bottom",
                autoclose: true,
            });

            $(`#myform`).find(`input[name='name']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='paterno']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='materno']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='cuip']`).classMaxCharacters(20);
            $(`#myform`).find(`input[name='curp']`).classMaxCharacters(18).allToUpperCase();
            $(`#myform`).find(`input[name='birth_date']`).classOnlyIntegers('/');
            $(`#myform`).find(`input[name='telephone']`).classOnlyIntegers().classMaxCharacters(10);
            $(`#myform`).find(`input[name='emergency_contact']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='telephone_emergency_contact']`).classOnlyIntegers().classMaxCharacters(10);
            $(`#myform`).find(`input[name='email']`).classOnlyEmail().classMaxCharacters(255);
            $(`#myform`).find(`input[name='blood_type']`).classMaxCharacters(255).allToUpperCase();

            $("#path_image").on("change", function() {
                readURL(this);
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ ($action == 'create') ? 'Registrar' : ($action == 'show' ? 'Ver' : 'Editar') }} estudiante</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create' ? route('estudiantes.store') : route('estudiantes.update', $estudiante->id) }}" method="post" enctype="multipart/form-data" id="myform">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-8">
                        @if($action != 'show')
                            <img src="{{ asset('/imgs/user.png') }}" id="profile-img-tag" width="200px" heigth="200px" />
                            <input class="form-control-file" type="file" id="path_image" name="path_image" value="{{ old('path_image') }}" accept="image/png,image/jpeg,image/jpg">
                            {!! $errors->first('path_image', '<small class="help-block text-danger">:message</small>') !!}
                            <br>
                        @else
                            <img src="data:image/{{ pathinfo($estudiante->path_image)['extension'] }};base64,{{ base64_encode(\Storage::get($estudiante->path_image)) }}" alt="Imagen" title="Imagen" width="200px" height="200px"/>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Corporación @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        @if($action != 'show')
                            <select id="corporation_id" class="form-select select2" name="corporation_id">
                                <option value=""></option>
                                @foreach($corporations as $corporation)
                                    <option value="{{ $corporation->id }}" @if(old('corporation_id', is_null($estudiante->corporation_id) ? null : $estudiante->corporation_id) == $corporation->id) selected @endif>
                                        {{ $corporation->corporation ?? "" }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input class="form-control readonlyshow" type="text" id="corporation_id" name="corporation_id" value="{{ old('corporation_id', $estudiante->corporation->corporation ?? "") }}" readonly>
                        @endif
                        {!! $errors->first('corporation_id', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Aspirante/Activo @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        @if($action != 'show')
                            <select class="form-select select2" id="type" name="type" style="text-align: left;">
                                <option value=""></option>
                                <option value="1" {{ old('type', $estudiante->type ?? "") == 1 ? 'selected' : '' }}>Aspirante</option>
                                <option value="2" {{ old('type', $estudiante->type ?? "") == 2 ? 'selected' : '' }}>Activo</option>
                            </select>
                        @else
                            @php
                                $tipo = "";

                                if(isset($estudiante->type)) {
                                    $tipo = $estudiante->type == 1 ? 'Aspirante' : 'Activo';
                                }
                            @endphp
                            <input class="form-control readonlyshow" type="text" id="type" name="type" value="{{ old('type', $tipo ?? "") }}" readonly>
                        @endif
                        {!! $errors->first('type', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Nombre @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="name" name="name" value="{{ old('name', $estudiante->name ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('name', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Primer apellido @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="paterno" name="paterno" value="{{ old('paterno', $estudiante->paterno ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('paterno', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Segundo apellido</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="materno" name="materno" value="{{ old('materno', $estudiante->materno ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('materno', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">CUIP @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="cuip" name="cuip" value="{{ old('cuip', $estudiante->cuip ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('cuip', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Fecha de nacimiento @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @else datepicker readonly @endif" type="text" id="birth_date" name="birth_date" value="{{ old('birth_date', $estudiante->birth_date ?? "") }}" readonly>
                        {!! $errors->first('birth_date', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">CURP @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="curp" name="curp" value="{{ old('curp', $estudiante->curp ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('curp', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">CUP</label>
                        @if($action != 'show')
                            <select class="form-select select2" id="cup" name="cup" style="text-align: left;">
                                <option value=""></option>
                                <option value="1" {{ old('cup', $estudiante->cup ?? "") == 1 ? 'selected' : '' }}>Opción 1</option>
                                <option value="2" {{ old('cup', $estudiante->cup ?? "") == 2 ? 'selected' : '' }}>Opción 2</option>
                            </select>
                        @else
                            @php
                                $cup = "";

                                if(isset($estudiante->cup)) {
                                    $cup = $estudiante->cup == 1 ? 'Opción 1' : 'Opción 2';
                                }
                            @endphp
                            <input class="form-control readonlyshow" type="text" id="cup" name="cup" value="{{ old('cup', $cup ?? "") }}" readonly>
                        @endif
                        {!! $errors->first('cup', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-8">
                        <label class="label-control">Dirección particular</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="address" name="address" value="{{ old('address', $estudiante->address ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('address', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Teléfono/celular @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="telephone" name="telephone" value="{{ old('telephone', $estudiante->telephone ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('telephone', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Correo electrónico @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="email" name="email" value="{{ old('email', $estudiante->email ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('email', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Contacto de emergencia @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $estudiante->emergency_contact ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('emergency_contact', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Teléfono/celular de contacto @if($action != 'show')<span class="text-danger">*</span>@endif</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="telephone_emergency_contact" name="telephone_emergency_contact" value="{{ old('telephone_emergency_contact', $estudiante->telephone_emergency_contact ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('telephone_emergency_contact', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Último grado de estudios</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="last_degree" name="last_degree" value="{{ old('last_degree', $estudiante->last_degree ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('last_degree', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Nombre de la dependencia donde labora</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="workplace" name="workplace" value="{{ old('workplace', $estudiante->workplace ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('workplace', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Cargo que desempeña</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="job" name="job" value="{{ old('job', $estudiante->job ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('job', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label class="label-control">Observaciones</label>
                        <textarea class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="observations" name="observations" rows="3" @if($action == 'show') readonly @endif>{{ old('observations', $estudiante->observations ?? "") }}</textarea>
                        {!! $errors->first('observations', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="panel-title text-center">Datos médicos</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="label-control">Tipo de sangre</label>
                        <input class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="blood_type" name="blood_type" value="{{ old('blood_type', $estudiante->blood_type ?? "") }}" @if($action == 'show') readonly @endif>
                        {!! $errors->first('blood_type', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label class="label-control">Nota médica</label>
                        <textarea class="form-control @if($action == 'show') readonlyshow @endif" type="text" id="medical_note" name="medical_note" rows="3" @if($action == 'show') readonly @endif>{{ old('medical_note', $estudiante->medical_note ?? "") }}</textarea>
                        {!! $errors->first('medical_note', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                @if($action == 'show')
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover">
                                <caption>Documentos</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Documento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($estudiante->documents as $document)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $document->name }}</td>
                                        <td>{{ $document->description }}</td>
                                        <td><a class="form-inline-file" href="{{ asset($document->path) }}" download="{{ $document->name }}"><em class="fas fa-file-pdf"></em> Descargar</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-6">
                        @if($action != 'show')
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create' ? 'Registrar' : 'Actualizar' }}
                        </button>
                        @endif
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection