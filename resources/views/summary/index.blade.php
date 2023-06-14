@extends('layouts.app')
@section('title', 'Módulo de Sumario')
@section('content')
    @include('summary.nav')
    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Listado de Mis Sumarios</h3>
        </div>
        <div class="col text-end">
            <a class="btn btn-success float-right" href="{{ route('summary.create') }}">
                <i class="fas fa-plus"></i> Nuevo Sumario
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Eventos</th>
                    <th>Estado</th>
                    <th>Usuario Creador</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($summaries as $summary)
                    <tr>
                        <td>{{ $summary->id ?? '' }}</td>
                        <td>{{ $summary->name ?? '' }}</td>
                        <td>Eventos</td>
                        <td>{{ $summary->status ?? '' }}</td>
                        <td>{{ $summary->creator->fullname ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
