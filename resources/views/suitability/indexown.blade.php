@extends('layouts.app')

@section('title', 'Listado de Todas las Solicitudes de Idoneidad')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Listado de Todas las Solicitudes de Idoneidad</h3>

<table class="table">
    <thead>
        <tr>
            <th>Solicitud N°</th>
            <th>Colegio</th>
            <th>Run</th>
            <th>Nombre Completo</th>
            <th>Cargo</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($psirequests as $psirequest)
        <tr>
            <td>{{$psirequest->id}}</td>
            <td>{{$psirequest->school->name}}</td>
            <td>{{$psirequest->user_external_id}}</td>
            <td>{{$psirequest->user->fullName}}</td>            
            <td>{{$psirequest->job}}</td>
            <td>{{$psirequest->user->email}}</td>
            <td>{{$psirequest->user->phone_number}}</td>
            <td>{{$psirequest->status}}</td>
        </tr>
    @endforeach
        
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection