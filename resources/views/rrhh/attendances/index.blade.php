@extends('layouts.app')

@section('title', 'Registros de asistencia')

@section('content')
<h3 class="mb-3">Registros de asistencia</h3>

<table class="table">
    <thead>
        <tr>
            <th>Run</th>
            <th>Marca</th>
            <th>Tipo</th>
            <th>Reloj</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $a)
        <tr>
            <td>{{ $a->user_id }}</td>
            <td>{{ $a->timestamp }}</td>
            <td>{{ $a->type }}</td>
            <td>{{ $a->clock_id }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('custom_js')

@endsection