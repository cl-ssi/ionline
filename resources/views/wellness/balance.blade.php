@extends('layouts.app')

@section('title', 'Módulo de Bienestar')

@section('content')

@include('wellness.nav')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Año</th>
                <th>Mes</th>
                <th>Tipo</th>
                <th>Código</th>
                <th>Título</th>
                <th>Ítem</th>
                <th>Asignación</th>
                <th>Glosa</th>
                <th>Inicial</th>
                <th>Traspaso</th>
                <th>Ajustado</th>
                <th>Ejecutado</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($balances as $balance)
            <tr>
                <td>{{ $balance->ano }}</td>
                <td>{{ $balance->mes }}</td>
                <td>{{ $balance->tipo }}</td>
                <td>{{ $balance->codigo }}</td>
                <td>{{ $balance->titulo }}</td>
                <td>{{ $balance->item }}</td>
                <td>{{ $balance->asignacion }}</td>
                <td>{{ $balance->glosa }}</td>
                <td>{{ $balance->inicial }}</td>
                <td>{{ $balance->traspaso }}</td>
                <td>{{ $balance->ajustado }}</td>
                <td>{{ $balance->ejecutado }}</td>
                <td>{{ $balance->saldo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection