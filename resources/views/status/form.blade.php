@extends('layouts.master')

@section('page-header')
    Gestor de estatus
@endsection

@push('customjs')
    <script type="text/javascript">
        $(document).ready(function() {
            $(`#myform`).find(`input[name='name']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='description']`).classMaxCharacters(255);
        });
    </script>
@endpush

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $action == 'create' ? 'Registrar' : 'Editar' }} estatus</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create' ? route('estatus.store') : route('estatus.update', $estatus->id) }}" method="post" id="myform">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Estatus <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $estatus->name ?? "") }}">
                        {!! $errors->first('name', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Descripción</label>
                        <input class="form-control" type="text" id="description" name="description" value="{{ old('description', $estatus->description ?? "") }}">
                        {!! $errors->first('description', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create' ? 'Registrar' : 'Actualizar' }}
                        </button>
                        <a href="{{ route('estatus.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection