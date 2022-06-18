@extends('auth.contenido')
@section('contenido')

@if(env('APP_MULTILANGUAGE'))
    <div class="row">
        <div class="col-12">
            <div class="dropdown pull-right">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('generic.leng')}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item @if(App::getLocale() == "en") active @endif" href="{{ url('locale/en') }}">{{ __('generic.english') }}</a>
                    <a class="dropdown-item @if(App::getLocale() == "es") active @endif" href="{{ url('locale/es') }}">{{ __('generic.spanish') }}</a>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card-group mb-0">
          <div class="card p-4 rounded" style="opacity: 0.95">
          <form class="form-horizontal was-validated" method="POST" action="{{route('login.post')}}">
            @csrf
              <div class="card-body">
                <div style="text-align: center"></div>

              <h3 class="text-center bg-while text-light p-2"><label style="color:#0074FF"> {{ __('auth.tittleLogin') }}</label></h3>

              <div class="form-group mb-3{{$errors->has('user' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('user')}}" name="user" id="user" class="form-control" placeholder="{{__('auth.placehoderUser')}}">
                {!!$errors->first('user','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="{{__('auth.placehoderPassword')}}">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-12">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                    @if (Session::has('g-recaptcha-response'))
                        <p class="alert {{ Session::get('alert-class','alert-info') }}">
                            @lang('auth.'.Session::get('g-recaptcha-response'))
                        </p>
                    @endif
                    <br/>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn bg-proyectobase text-light px-4 rounded"><i class="fa fa-sign-in fa-2x"></i> {{__('auth.btn-enter')}}</button>
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
@endsection
