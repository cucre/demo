<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>Demo</title>
    <link rel="SHORTCUT ICON" href="/imgs/favicon.ico" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0 user-scalable=no" name="viewport" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/default/app.min.css') }}" />
    <link rel="stylesheet" id="theme-css-link" type="text/css" href="{{ asset('/assets/css/default/theme/blue.min.css') }}" >
    <!-- ================== END BASE CSS STYLE ================== -->
</head>

<body class="pace-top">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show">
        <span class="spinner"></span>
    </div>
    <!-- end #page-loader -->

    <!-- begin login-cover -->
    <div class="login-cover">
        <div class="login-cover-bg"></div>
    </div>
    <!-- end login-cover -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand" style="text-align: center;">
                    <b> Cambiar contraseña </b>
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <form method="POST" action="{{ route('password.update') }}" class="margin-bottom-0">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus />
                        {!! $errors->first('email', '<br><div class="alert alert-danger text-center">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" required />
                            <div class="input-group-append">
                                <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                        </div>
                        <p>Mínimo 6 caracteres</p>
                        {!! $errors->first('password', '<br><div class="alert alert-danger text-center">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                        <div class="input-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"  required />
                            <div class="input-group-append">
                                <button id="show_password_confirmation" class="btn btn-primary" type="button" onclick="mostrarPasswordConfirmation()"> <span class="fa fa-eye-slash icon_confirmation"></span> </button>
                            </div>
                        </div>
                        <p>Mínimo 6 caracteres</p>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{ asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('/assets/js/theme/default.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //CheckBox mostrar contraseña
            $().on("click", '#show_password', function () {
                $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });

            $().on("click", '#show_password_confirmation', function () {
                $('#password_confirmation').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });

        function mostrarPassword() {
            let cambio = document.getElementById("password");

            if(cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }

        function mostrarPasswordConfirmation() {
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
    <!-- ================== END BASE JS ================== -->
</body>
</html>