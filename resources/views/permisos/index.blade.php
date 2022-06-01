
@extends('dashboard')

@section('contenido')
            <div class="container-fluid">
                <div class="row">
                    <ul>
                        @foreach ($permisos as $permiso)
                            <li>{{$permiso->controlador}} - {{$permiso->metodo}} - {{$permiso->nombre}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
@endsection
