
@extends('dashboard.dashboard')

@section('contenido')
            <div class="container-fluid">
                <div class="row">
                    <ul>
                        <li>CONTROLLER - ACTION - NAME- DESCRIPTION</li>

                        @foreach ($routes as $route)
                            <li>{{$route->controller}} - {{$route->action}} - {{$route->name}} - {{$route->description}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
@endsection
