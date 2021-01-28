@extends('layouts.app')

@section('content')

@include('suitability.nav')
<h3 class="mb-3">Listado de Resultados</h3>

<table class="table">
    <thead>
        <tr>
            <th>ID de Test</th>
            <th>Nombre</th>
            <th>Cargo</th>
            <th>Total de Puntos</th>
            <th>Hora de Termino de Test</th>
            <th>Ver Test</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
        <tr>
            <td>{{ $result->id ?? '' }}</td>
            <td>{{ $result->user->fullName ?? ''  }}</td>
            <td>{{ $result->psirequest->job ?? ''  }}</td>
            <td>{{ $result->total_points ?? '' }}</td>
            <td>{{ $result->created_at ?? '' }}</td>
            <td>
            <a href="{{ route('suitability.results.show', $result->id) }}" class="btn btn-outline-primary">
				<span class="fas fa-edit" aria-hidden="true"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection

@section('custom_js')


@endsection