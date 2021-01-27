@extends('layouts.app')

@section('title', 'Listado de Mis Solicitudes de Idoneidad')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Listado de mis Solicitudes de Idoneidad</h3>

<table class="table">
    <thead>
        <tr>
            <th>Run</th>
            <th>Nombre Completo</th>
            <th>Cargo</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($psirequests as $psirequest)
        <tr>
            <td>{{$psirequest->user_id}}</td>
            <td>{{$psirequest->user->fullName}}</td>
            <td>{{$psirequest->user->position}}</td>
            <td>{{$psirequest->status}}</td>
        </tr>
    @endforeach
        
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection