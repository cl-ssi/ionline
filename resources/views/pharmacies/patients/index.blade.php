@extends('layouts.bt4.app')

@section('title', 'Lista de Pacientes')

@section('content')

@include('pharmacies.nav')

<h3 class="inline">Pacientes
    <a href="{{ route('pharmacies.patients.create') }}" class="btn btn-primary">Crear</a>
</h3>

<br>

<form action="{{ route('pharmacies.patients.index') }}" method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o RUT..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<br>

<table class="table table-striped table-sm table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>RUT</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Centro Médico</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($patients as $patient)
        <tr>
            <td>{{ $patient->full_name }}</td>
            <td>{{ $patient->rut }}</td>
            <td>{{ $patient->phone }}</td>
            <td>{{ $patient->address }}</td>
            <td>{{ $patient->medical_center }}</td>
            <td>
                <a href="{{ route('pharmacies.patients.edit', $patient) }}"
                    class="btn btn-sm btn-outline-secondary">
                    <span class="fas fa-edit" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $patients->appends(request()->query())->links() }}

@endsection
