@extends('layouts.app')

@section('title', 'Listado de Mis Solicitudes de Idoneidad')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Listado de Solicitudes Pendiente (Test Finalizado)</h3>

<form method="GET" class="form-horizontal" action="{{ route('suitability.pending') }}">

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

<table class="table">
    <thead>
        <tr>
            <th>Solicitud N°</th>
            <th>Colegio</th>
            <th>Run</th>
            <th>Nombre Completo</th>
            <th>Cargo</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Puntaje</th>
            <th>Aceptar</th>
            <th>Rechazar</th>
        </tr>
    </thead>
    <tbody>
    @foreach($psirequests as $psirequest)
        <tr>
            <td>{{$psirequest->id ?? ''}}</td>
            <td>{{ $psirequest->school->name ?? ''  }}</td>
            <td>{{$psirequest->user->runFormat() ?? ''}}</td>
            <td>{{$psirequest->user->fullName ?? ''}}</td>
            <td>{{$psirequest->job ?? ''}}</td>
            <td>{{$psirequest->user->email ?? ''}}</td>
            <td>{{$psirequest->status ?? ''}}</td>
            <td>{{$psirequest->result->total_points ?? ''}}</td>
            <td>
            <form action="{{ route('suitability.finalresult',['psirequest' => $psirequest, 'result' => 'Aprobado']) }}" method="POST" >
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success float-left"><i class="fa fa-check"></i></button>
            </form>
            </td>
            <td>
            <form action="{{ route('suitability.finalresult',['psirequest' => $psirequest, 'result' => 'Rechazado']) }}" method="POST" >
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea Rechazar la Solicitud de Idoneidad de {{$psirequest->user->fullName}}?' )"><i class="fa fa-ban"></i></button>
            </form>
            </td>
        </tr>
    @endforeach
        
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection