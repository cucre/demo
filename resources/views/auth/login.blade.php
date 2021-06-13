<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    <meta charset="utf-8" />
   <title>
        @yield('title', 'Demo')
    </title>
    <link rel="SHORTCUT ICON" href="{{ asset('/imgs/favicon.ico') }}" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0 user-scalable=no" name="viewport" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/material/app.min.css') }}" />
    <link rel="stylesheet" id="theme-css-link" type="text/css" href="{{ asset('/assets/css/material/theme/blue.min.css') }}" >
    <!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-done">
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
                <span style="text-align: center; display: block;"><img src="{{ asset('/imgs/logo.png') }}" class="center" style="background-color: white;"></span>
                <div class="brand" style="text-align: center;">
                    <b> Inicio de sesión </b>
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="{{ route('login') }}" method="post" class="margin-bottom-0">
                    @csrf
                    <div class="form-group m-b-20">
                        <label class="form-label">Correo electrónico</label>
                        <input type="text" name="email" class="form-control form-control-lg" placeholder="Correo electrónico" required />
                    </div>
                    <div class="form-group m-b-20">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Contraseña" required />
                            <div class="input-group-append">
                                <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                        </div>
                    </div>
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Ingresar</button>
                    </div>
                    {!! $errors->first('email', '<br><div class="alert alert-danger text-center">:message</div>') !!}
                    <div class="m-t-20 text-center">
                        <a href="{{ route('password.request') }}">Restablecer contraseña</a>
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
    <script type="text/javascript" src="{{ asset('/assets/js/app.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/theme/material.min.js') }}"></script>
    <!-- ================== END BASE JS ================== -->
    <script type="text/javascript">
        $(document).ready(function () {
            //CheckBox mostrar contraseña
            $().on("click", '#show_password', function () {
                $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
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
    </script>
</body>
</html>