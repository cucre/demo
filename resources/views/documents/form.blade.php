@extends('layouts.master')

@section('page-header')
    <p style="font-size: 18px;">Nombre del Instructor: <strong style="color: blue;">{{ $instructor->full_name }}</strong>.</p>
@endsection

@push('customjs')
    <script type="text/javascript">
        $(document).ready(function() {
            $(`#myform`).find(`input[name='name']`).classMaxCharacters(255);
        });
    </script>
@endpush

@push('customcss')
    <style type="text/css">
        textarea {
            resize: none;
            padding: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $action == 'create' ? 'Registrar' : 'Editar' }} documento</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create' ? route('documentos.store') : route('documentos.update', $documento->id) }}" method="post" enctype="multipart/form-data" id="myform">
                <input class="form-control" type="hidden" id="instructor_id" name="instructor_id" value="{{ old('instructor_id', $instructor->id ?? "") }}">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Nombre del documento <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $documento->name ?? "") }}">
                        {!! $errors->first('name', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-8">
                        <label class="label-control">Descripción</label>
                        <textarea class="form-control" type="text" id="description" name="description" rows="2">{{ old('description', $documento->description ?? "") }}</textarea>
                        {!! $errors->first('description', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Documento @if($action == 'create') <span class="text-danger">*</span> @endif</label>
                        <input class="form-control-file" type="file" id="path" name="path" value="{{ old('path') }}" accept="application/pdf">
                        {!! $errors->first('path', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    @if($action == 'edit')
                        <div class="col-lg-4">
                            <label class="label-control">Documento actual</label>
                            <a class="form-control-file" href="{{ asset($documento->path) }}" download="{{ $documento->name }}"><em class="fas fa-file-pdf"></em> Descargar</a>
                            <br>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create' ? 'Registrar' : 'Actualizar' }}
                        </button>
                        <a href="{{ route('documentos.index', $instructor->id) }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection