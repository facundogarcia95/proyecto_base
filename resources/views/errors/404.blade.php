@extends('dashboard.dashboard')
@section('contenido')

   <div class="card">
      <div class="overlay"></div>
      <div class="terminal">
         <h1> <span class="errorcode">Error 404</span></h1>
         <p class="output">La página que está buscando no existe.</p>
         <p class="output">Intenta volviendo <a id="back" href="#">atrás</a> o simplemente <a href="{{url('/')}}">volver al inicio</a>.</p>
         <p class="output">Saludos.</p>
      </div>
   </div>
</div>

    @push('scripts')
    <script>
       $("#back").on('click',function(){
         window.history.back();
       })
    </script>
    @endpush

    @push('css')
    <link href="{{asset('css/librerias/404.css')}}" rel="stylesheet">

    @endpush
@endsection
