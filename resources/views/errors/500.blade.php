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
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <div class="brand" style="text-align: center;">
                    <h3>Solicitud no atendida (500).</h3>
                </div>
                <div class="row">
                    <div class="center">
                        Disculpe las molestias, no podemos atender su solicitud, favor de reportarlo al Administrador.
                    </div>
                </div>
                <div class="m-t-20 text-center">
                    <a class="btn btn-primary" href="{{ route('home') }}">Iniciar al inicio</a>
                </div>
            </div>
            <!-- end login-content -->
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('/assets/js/app.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/theme/material.min.js') }}"></script>
</body>
</html>