
@extends('dashboard')

@section('contenido')
            <div class="container-fluid">
                <div class="row">
                    <ul>
                        @foreach ($users as $user)
                            <li>{{$user->email}} - {{$user->num_doc}} - {{$user->rol->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
@endsection
