@extends('layouts.master')

@section('page-header')
    Cambiar contraseña
@endsection

@push('customjs')
    <script type="text/javascript">
        $(document).ready(function() {
            $(`#myform`).find(`input[name='current_password']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='password']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='password_confirmation']`).classMaxCharacters(255);

            //CheckBox mostrar contraseña
            $().on("click", '#show_current_password', function () {
                $('#current_password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });

            $().on("click", '#show_password', function () {
                $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });

            $().on("click", '#show_password_confirmation', function () {
                $('#password_confirmation').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });

        function showCurrentPassword() {
            let cambio = document.getElementById("current_password");

            if(cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }

        function showPassword() {
            let cambio = document.getElementById("password");

            if(cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }

        function showPasswordConfirmation() {
            let cambio = document.getElementById("password_confirmation");

            if(cambio.type == "password") {
                cambio.type = "text";
                $('.icon_confirmation').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon_confirmation').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }
    </script>
@endpush

@section('content')
    @if(session()->has('error'))
        <div class="panel-heading flash-msg">
            <div class="alert alert-danger">{{ session()->get('error') }}
                <button class="close" data-dismiss="alert" aria-hidden="true">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </div>
    @endif
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Editar contraseña</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('change.password') }}" id="myform">
                    @csrf
                    <div class="form-group">
                        <label for="current_password" class="form-label">Contraseña actual</label>
                        <div class="input-group">
                            <input type="password" id="current_password" name="current_password" class="form-control" value="{{ old('current_password') }}" required />
                            <div class="input-group-append">
                                <button id="show_current_password" class="btn btn-primary" type="button" onclick="showCurrentPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                        </div>
                        {!! $errors->first('current_password', '<small class="help-block text-danger">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}" required />
                            <div class="input-group-append">
                                <button id="show_password" class="btn btn-primary" type="button" onclick="showPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                        </div>
                        <p>Mínimo 6 caracteres</p>
                        {!! $errors->first('password', '<small class="help-block text-danger">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="form-label">Confirmación nueva contraseña</label>
                        <div class="input-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" required />
                            <div class="input-group-append">
                                <button id="show_password_confirmation" class="btn btn-primary" type="button" onclick="showPasswordConfirmation()"> <span class="fa fa-eye-slash icon_confirmation"></span> </button>
                            </div>
                        </div>
                        <p>Mínimo 6 caracteres</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <button class="btn btn-primary">
                                <i class="fas fa-check-circle"></i> Actualizar
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-warning">
                                <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                            </a>
                        </div>
                    </div>
                </form>
            </form>
        </div>
    </div>
@endsection