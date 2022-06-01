
@extends('dashboard')

@section('contenido')
            <div class="container-fluid">
                <div class="row">
                    <ul>
                        @foreach ($usuarios as $usuario)
                            <li>{{$usuario->email}} - {{$usuario->num_documento}} - {{$usuario->rol->nombre}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
@endsection