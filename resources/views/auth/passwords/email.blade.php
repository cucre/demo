<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>Demo</title>
    <link rel="SHORTCUT ICON" href="{{ asset('/imgs/favicon.ico') }}" type="image/x-icon">
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
                <span style="text-align: center; display: block;"><img src="{{ asset('/imgs/logo.png') }}" class="center" style="background-color: white;"></span>
                <div class="brand" style="text-align: center;">
                    <b> Restablecer contraseña </b>
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group row">
                        <p style="text-align: center;" class="center">Enviaremos la nueva contraseña a tu correo electrónico</p>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-8">
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            {!! $errors->first('email', '<br><div class="alert alert-danger text-center">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="col-md-12 btn btn-primary">
                                Enviar
                            </button>
                        </div>
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
    <!-- ================== END BASE JS ================== -->
</body>
</html>