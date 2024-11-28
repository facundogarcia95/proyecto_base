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
  <link href="{{asset('css/librerias/jquery-ui.css')}}" rel="stylesheet" />
  <link href="{{asset('css/librerias/style.css')}}" rel="stylesheet">
  <link href="{{asset('css/librerias/estilos.css')}}" rel="stylesheet">
  <link href="{{asset('css/librerias/jquery.dataTables.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/librerias/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/librerias/select2.css')}}" rel="stylesheet">

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
      @if(env('APP_MULTILANGUAGE'))
        <li class="nav-item dropdown">
        <a class="nav-link mr-4 rounded" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
          aria-expanded="false">
          <span>{{__('generic.leng')}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right rounded">
          <a class="dropdown-item @if(App::getLocale() == "en") active @endif"
          href="{{ url('locale/en') }}">{{ __('generic.english') }}</a>
          <a class="dropdown-item @if(App::getLocale() == "es") active @endif"
          href="{{ url('locale/es') }}">{{ __('generic.spanish') }}</a>
        </div>
        </li>
      @endif

      @if(Auth::check())
        <li class="nav-item dropdown">
          <a class="nav-link mr-4" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
            aria-expanded="false">
            <img src="{{asset('imgs/avatars/4.jpg')}}" class="img-avatar" class="img-avatar" alt="Imagen Avatar">
            <span>{{Auth::user()->user}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right rounded">
            <div class="dropdown-header text-center">
             <strong>@lang('generic.account')</strong>
            </div>
            <a class="dropdown-item pointer" data-toggle="modal" data-target="#changeProfile">
              <i class="fa fa-user"></i> @lang('generic.profile')
            </a>
            <a class="dropdown-item pointer" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fa fa-lock"></i> @lang('generic.logout')
            </a>
            <form id="logout-form" action="{{url('logout')}}" method="GET" style="display: none;">
            {{ csrf_field() }}
            </form>
          </div>
        </li>
      @endif
    </ul>
  </header>

  <div class="app-body">

    @if(Auth::check())
      @include('navbar.sidebar')
    @endif

    <!-- Contenido Principal -->
    <main class="main">
      @yield('contenido')

      <div class="modal fade" id="changeProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-dark" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title">@lang('generic.changeProfile')</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true" class="text-light">×</span>
                      </button>
                  </div>

                  <div class="modal-body">
                      <form action="{{route('users.modifyProfile','update')}}" method="post" class="form-horizontal was-validated"
                          enctype="multipart/form-data">
                          {{method_field('post')}}
                          {{csrf_field()}}
                          <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <label for="name">@lang('form.name')</label>
                                <input name="name" type="text" class="form-control"  maxlength="100" id="name" placeholder="@lang('form.name')" value="{{Auth::user()->name}}" required>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="cel_number">@lang('form.cel_number')</label>
                                <input data-inputmask="'mask': '(999)-15-9999999'" data-mask="" type="text" name="cel_number"  maxlength="20" class="form-control" id="cel_number" placeholder="@lang('form.cel_number')" value="{{Auth::user()->cel_number}}">
                            </div>
                            <div class="form-group col-12 col-md-12">
                                <label for="adress">@lang('form.adress')</label>
                                <input type="text" class="form-control"  maxlength="70" id="adress" name="adress" placeholder="@lang('form.adress')" value="{{Auth::user()->adress}}">
                            </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-12 col-md-6">
                            <label for="password">@lang('form.password')</label>
                            <input name="password" type="password" class="form-control" minlength="8"  maxlength="100" id="password" placeholder="@lang('form.password')">
                          </div>
                          <div class="form-group col-12 col-md-6">
                            <label for="confirm_password">@lang('form.confirm_password')</label>
                            <input name="confirm_password" type="password" class="form-control"   minlength="8" maxlength="100" id="confirm_password" placeholder="@lang('form.confirm_password')">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-12">
                            <button  type="button" data-dismiss="modal" class="btn btn-danger rounded pull-left">@lang('form.cancel') <i class="fa fa-times"></i></button>
                            <button type="submit" class="btn btn-success rounded pull-right">@lang('form.save') <i class="fa fa-save"></i></button>
                          </div>
                        </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    </main>

    <!-- /Fin del contenido principal -->

  </div>
  <footer class="bg-footer bg-dark">
    <span class="ml-auto"><a href="{{ route('home') }}" class="font-weight-bold">{{ env('APP_ADM_TITLE') }}</a> &copy;
      2024</span>
  </footer>

  <!-- Bootstrap and necessary plugins -->
  <script src="{{asset('js/librerias/jquery.min.js')}}"></script>
  <script src="{{asset('js/librerias/jquery-ui.js')}}"></script>
  <script src="{{asset('js/librerias/jquery-migrate-3.0.0.min.js')}}"></script>
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
  <script src="{{asset('js/librerias/select2.js')}}"></script>
  <script>
    const RUTA = "{{Request::route()->getName()}}";
    $('.modal').on('show.bs.modal', function (event) {
      var modal = $(this)
      modal.find('select').select2();
    });
  </script>

  @stack('scripts')


</body>

</html>