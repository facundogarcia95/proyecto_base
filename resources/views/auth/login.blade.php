@extends('auth.contenido')
@section('contenido')

@if(env('APP_MULTILANGUAGE'))
    <div class="row mt-5 mb-2">
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

<div class="row justify-content-center my-auto">
      <div class="col-md-5">
        <div class="card-group mb-0">
          <div class="card p-4 rounded" style="opacity: 0.95">
          <form class="form-horizontal " method="POST" action="{{route('login.post')}}">
            @csrf
              <div class="card-body">
                <div style="text-align: center"></div>
                
                <h5 class="text-center font-weight-bold text-light"><label style="color:#323232"> {{ __('auth.tittleLogin') }}</label></h5>

                <div class="input-group mb-2 mr-sm-2 {{$errors->has('user' ? 'is-invalid' : '')}}">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="icon-user"></i></div>
                  </div>
                  <input type="text" value="{{old('user')}}" name="user" id="user" class="form-control" placeholder="{{__('auth.placehoderUser')}}" required>
                  {!!$errors->first('user','<span class="invalid-feedback">:message</span>')!!}
                </div>

                <div class="input-group mb-2 mr-sm-2 {{$errors->has('password' ? 'is-invalid' : '')}}">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="icon-lock"></i></div>
                  </div>
                  <input type="password" name="password" id="password" class="form-control" placeholder="{{__('auth.placehoderPassword')}}" required>
                  {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
                </div>

                <div class="row">
                  <div class="col-12">
                      <div class="g-recaptcha" style="margin-bottom: -30px" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                      @if (Session::has('g-recaptcha-response'))
                          <p class="alert {{ Session::get('alert-class','alert-info') }}">
                              @lang('auth.'.Session::get('g-recaptcha-response'))
                          </p>
                      @endif
                      <br/>
                      @if (Session::has('custom-error'))
                      <p class="alert {{ Session::get('alert-class','alert-info') }}">
                          @lang(Session::get('custom-error'))
                      </p>
                      @endif
                  </div>
                  <div class="col-12">
                    <button type="submit" class="btn text-light px-4 rounded" style="background-color: #00b09b"><i class="fa fa-sign-in"></i> {{__('auth.btn-enter')}}</button>
                  </div>
                </div>

            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
@endsection
