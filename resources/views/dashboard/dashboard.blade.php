
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema ">
    <meta name="keyword" content="Sistema">
    <meta name="csrf-token" content="{{csrf_token()}}">
    @stack('header')

    <title>{{env('APP_ADM_TITLE')}}</title>

    @stack('css')
    <!-- Icons -->
    <link href="{{asset('css/librerias/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/librerias/simple-line-icons.min.css')}}" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="{{asset('css/librerias/jquery-ui.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/librerias/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/librerias/estilos.css')}}" rel="stylesheet">
    <link href="{{asset('css/librerias/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/librerias/responsive.bootstrap.min.css')}}" rel="stylesheet">

</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!--PONER LOGO-->
        <!--<a class="navbar-brand" href="#"></a>-->
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">@lang('generic.menu')</a>
            </li>

        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link mr-4" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span >{{__('generic.leng')}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item @if(App::getLocale() == "en") active @endif" href="{{ url('locale/en') }}">{{ __('generic.english') }}</a>
                    <a class="dropdown-item @if(App::getLocale() == "es") active @endif" href="{{ url('locale/es') }}">{{ __('generic.spanish') }}</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link mr-4" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{asset('imgs/avatars/4.jpg')}}" class="img-avatar" class="img-avatar" alt="Imagen Avatar">
                    <span>{{Auth::user()->user}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesión</a>
                    <form id="logout-form" action="{{url('logout')}}" method="GET" style="display: none;">
                    {{ csrf_field() }}
                    </form>
                </div>
            </li>

        </ul>
    </header>

    <div class="app-body">

        @if(Auth::check())
            @if (Auth::user()->idrol == 1)
                @include('navbar.sidebaradministrador')
            @endif

        @endif

        @if ($errors->any())
                <script>
                        var text = "";
                    @foreach ($errors->all() as $error)
                        text = text + "<li>"+ {{ $error }} + "</li> <br/>"
                    @endforeach

                        Swal.fire({
                        type: 'error',
                        //title: 'Oops...',
                        html: text,

                        })

                </script>
            <div class="alert alert-danger">
                <ul>

                </ul>
            </div>
        @endif
        <!-- Contenido Principal -->
        <main class="main">
            @yield('contenido')
        </main>

        <!-- /Fin del contenido principal -->

    </div>
    <footer class="bg-footer bg-dark">
        <span class="ml-auto"><a href="{{ route('home') }}"  class="font-weight-bold">{{ env('APP_ADM_TITLE') }}</a> &copy; 2021</span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script>const RUTA = "{{Request::route()->getName()}}";</script>
    <script  src="{{asset('js/librerias/jquery.min.js')}}"></script>
    <script  src="{{asset('js/librerias/jquery-ui.js')}}"></script>
    <script  src="{{asset('js/librerias/jquery-migrate-3.0.0.min.js')}}"></script>
    <script src="{{asset('js/librerias/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/librerias/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/librerias/moment.min.js')}}"></script>
    <script src="{{asset('js/librerias/popper.min.js')}}"></script>
    <script src="{{asset('js/librerias/bootstrap.min.js')}}"></script>
    <!-- Plugins and scripts required by all views -->
    <script src="{{asset('js/librerias/Chart.min.js')}}"></script>
    <script src="{{asset('js/librerias/util.js')}}"></script>
    <!-- GenesisUI main scripts -->
    <script src="{{asset('js/librerias/template.js')}}"></script>
    <script src="{{asset('js/librerias/sweetalert2.all.min.js')}}"></script>

    <script src="{{asset('js/librerias/inputmask.js')}}"></script>
    <script src="{{asset('js/librerias/inputmask.extensions.js')}}"></script>
    <script src="{{asset('js/librerias/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>

 @stack('scripts')


</body>

</html>
