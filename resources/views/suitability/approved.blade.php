@extends('layouts.app')

@section('title', 'Listado de Solicitudes de Idoneidad Aprobadas')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Listado de Solicitudes Aprobadas</h3>

<table class="table">
    <thead>
        <tr>
            <th>Solicitud N°</th>
            <th>Run</th>
            <th>Nombre Completo</th>
            <th>Cargo</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Fecha de Aprobación</th>
        </tr>
    </thead>
    <tbody>
    @foreach($psirequests as $psirequest)
        <tr>
            <td>{{$psirequest->id}}</td>
            <td>{{$psirequest->user_id}}</td>
            <td>{{$psirequest->user->fullName}}</td>
            <td>{{$psirequest->job}}</td>
            <td>{{$psirequest->user->email}}</td>
            <td>{{$psirequest->status}}</td>
            <td>{{$psirequest->updated_at}}</td>
        </tr>
    @endforeach
        
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection