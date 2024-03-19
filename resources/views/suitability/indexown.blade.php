@extends('layouts.bt4.app')

@section('title', 'Listado de Todas las Solicitudes de Idoneidad')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Listado de Todas las Solicitudes de Idoneidad ({{ $psirequests_count }})</h3>

<form method="GET" class="form-horizontal" action="{{ route('suitability.own') }}">

    <div class="form-row">
        <fieldset class="form-group col-6 col-md-6">
            <label for="for_year">Colegios</label>
            <select name="colegio" class="form-control selectpicker" data-live-search="true">
                <option value="">Todos Los Colegios</option>
                @foreach($schools as $school)
                <option value="{{$school->id}}" @if($school_id==$school->id) selected @endif >{{$school->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-4">
            <label for="search">Buscar por nombre o apellido</label>
            <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}">
        </fieldset>


        <fieldset class="form-group col-6 col-md-1">
            <label for="search">Año</label>
                    <select class="form-control" id="for_yearFilter" name="yearFilter">
                        <option value="todos"> Todos</option>
                        @foreach(range(2022, now()->year) as $year)
                            <option value="{{ $year }}" @if($selectedYear == $year) selected @endif>{{ $year }}</option>
                        @endforeach
                	</select>
        </fieldset>




        <fieldset class="form-group col-2 col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>

</form>

    <table class="table table-sm">
        <thead>
            <tr>
                <th>Solicitud N°</th>
                <th>Fecha de Solicitud</th>
                <th>Colegio</th>
                <th>Run</th>
                <th>Nombre Completo</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Estado</th>
                <th>Eliminar</th>
                <th>Volver a "Esperando Test"</th>
            </tr>
        </thead>
        <tbody>
            @foreach($psirequests as $psirequest)
            <tr>
                <td>{{$psirequest->id}}</td>
                <td>{{$psirequest->created_at}}</td>
                <td>{{$psirequest->school->name}}</td>
                <td>{{$psirequest->user_external_id}}</td>
                <td>{{$psirequest->user->fullName}}</td>
                <td>{{$psirequest->job}}</td>
                <td>{{$psirequest->user->email}}</td>
                <td>{{$psirequest->user->phone_number}}</td>
                <td>{{$psirequest->status}}</td>
                <td>
                    @if($psirequest->status == 'Esperando Test' or $psirequest->status == 'Test Finalizado')
                    <form method="POST" action="{{ route('suitability.destroy', $psirequest) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta solicitud de idoneidad?')">
                            <span class="fas fa-trash-alt" aria-hidden="true"></span>
                        </button>
                    </form>
                    @endif

                </td>
                <td>
                @if($psirequest->status == 'Realizando Test' )
                <form method="POST" action="{{ route('suitability.update', $psirequest) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Volverá el Test a Esperando Test, esto debe realizar solo cuando el asistente a la educación, no pudo terminar el test')">
                            <span class="fa fa-spinner" aria-hidden="true"></span>
                        </button>
                    </form>
                @endif
                </td>
            </tr>
            @endforeach

        </tbody>

    </table>

    {{ $psirequests->links() }}

    @endsection

    @section('custom_js')

    @endsection