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


    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Asunto</th>
                <th>Nº Res.</th>
                <th>Fecha Res.</th>
                <th>Estado/Último Evento</th>
                <th>Duración</th>
                <th>Fiscal</th>
                <th>Actuario</th>
                <th width="60"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($summaries as $summary)
                <tr>
                    <td>
                        {{ $summary->id }}
                        @if ($summary->end_at)
                            <i class="fas fa-lock"></i>
                        @else
                            <i class="fas fa-lock-open"></i>
                        @endif
                    </td>
                    <td>{{ $summary->subject }}</td>
                    <td>{{ $summary->resolution_number }}</td>
                    <td>{{ optional($summary->resolution_date)->format('Y-m-d') }}</td>
                    <td>{{ $summary->lastEvent->type->name ?? '' }}</td>
                    <td>{{ $summary->start_at->diffInDays(now()) }}</td>
                    <td>{{ optional($summary->investigator)->tinnyName }}</td>
                    <td>{{ optional($summary->actuary)->tinnyName }}</td>
                    <td>
                        <a href="{{ route('summary.edit', $summary) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
