
@extends('dashboard.dashboard')

@section('contenido')
            <div class="container-fluid">
                <div class="row">
                    <ul>
                        @foreach ($roles as $rol)
                            <li>{{$rol->nombre}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
@endsection
