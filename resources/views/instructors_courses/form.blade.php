@extends('layouts.master')

@section('page-header')
    <p style="font-size: 18px;">Nombre curso: <strong style="color: blue;">{{ $curso->name }}</strong>. Fecha inicio: <strong style="color: blue;">{{ date('d/m/Y', strtotime($curso->start_date)) }}</strong></p>
@endsection

@push('customjs')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2({
                placeholder: "Selecciona",
                width: "100%",
                allowClear: true,
                language: 'es'
            });
        });
    </script>
@endpush

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $action == 'create' ? 'Registrar' : 'Editar' }} instructores por curso</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create' ? route('instructores_cursos.instructores.store') : route('instructores_cursos.instructores.update', $instructor_curso->id) }}" method="post" id="myform">
                <input class="form-control" type="hidden" id="course_id" name="course_id" value="{{ old('curso', $curso->id ?? "") }}">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">CUIP/Nombre del instructor <span class="text-danger">*</span></label>
                        <select id="instructor_id" class="form-select select2" name="instructor_id">
                            <option value=""></option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}" @if(old('instructor_id', is_null($instructor_curso->instructor_id) ? null : $instructor_curso->instructor_id) == $instructor->id) selected @endif>
                                    {{ ($instructor->cuip ?? "") .' - '. ($instructor->full_name ?? "") }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('instructor_id', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Materias <span class="text-danger">*</span></label>
                        <select id="subject_id" class="form-select select2" name="subject_id">
                            <option value=""></option>
                            @foreach($courses_subjects->subjects as $course)
                                <option value="{{ $course->id }}" @if(old('subject_id', is_null($instructor_curso->subject_id) ? null : $instructor_curso->subject_id) == $course->id) selected @endif>
                                    {{ $course->subject }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('subject_id', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create' ? 'Registrar' : 'Actualizar' }}
                        </button>
                        <a href="{{ route('instructores_cursos.index', $curso) }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection