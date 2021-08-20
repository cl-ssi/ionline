@extends('layouts.app')

@section('title', 'Listado de Todas las Solicitudes de Idoneidad')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Listado de Todas las Solicitudes de Idoneidad</h3>

<form method="GET" class="form-horizontal" action="{{ route('suitability.own') }}">

    <div class="form-row">
        <fieldset class="form-group col-6 col-md-6">
            <label for="for_year">Colegios</label>
            <select name="colegio" class="form-control selectpicker" data-live-search="true" >
                <option value="">Todos Los Colegios</option>
                @foreach($schools as $school)
                <option value="{{$school->id}}" @if($school_id == $school->id) selected @endif >{{$school->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>

</forn>

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