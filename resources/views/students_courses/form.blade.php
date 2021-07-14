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
            <h4 class="panel-title">Registrar estudiante por curso</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ route('estudiantes_cursos.store') }}" method="post" id="myform">
                <input class="form-control" type="hidden" id="course_id" name="course_id" value="{{ old('curso', $curso->id ?? "") }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">CUIP/Nombre del instructor <span class="text-danger">*</span></label>
                        <select id="student_id" class="form-select select2" name="student_id">
                            <option value=""></option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" @if(old('student_id', is_null($estudiante->student_id) ? null : $estudiante->student_id) == $student->id) selected @endif>
                                    {{ ($student->cuip ?? "") .' - '. ($student->full_name ?? "") }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('student_id', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> Registrar
                        </button>
                        <a href="{{ route('estudiantes_cursos.index', $curso) }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection