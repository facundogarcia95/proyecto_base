<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keyword" content="">


    <title>{{env('APP_TITLE')}}</title>

    <!-- Icons -->
    <link href="{{asset('css/librerias/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/librerias/simple-line-icons.min.css')}}" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="{{asset('css/librerias/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/librerias/estilos.css')}}" rel="stylesheet">
    <style>
    body {
        background-image:url("{{asset('img').'/'.env('IMAGEN_FONDO')}}");
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    </style>
    <script src="https://www.google.com/recaptcha/api.js?hl={{ str_replace('_', '-', app()->getLocale()) }}" async defer></script>

</head>

<body class="app flex-row align-items-center">
    <div class="container">
     @yield('contenido')
  </div>

   <!-- Bootstrap and necessary plugins -->
    <script src="{{asset('js/librerias/jquery.min.js')}}"></script>
    @stack('scripts')
    <script src="{{asset('js/librerias/popper.min.js')}}"></script>
    <script src="{{asset('js/librerias/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/librerias/pace.min.js')}}"></script>
    <!-- Plugins and scripts required by all views -->
    <script src="{{asset('js/librerias/Chart.min.js')}}"></script>
    <!-- GenesisUI main scripts -->
    <script src="{{asset('js/librerias/template.js')}}"></script>
</body>
</html>
