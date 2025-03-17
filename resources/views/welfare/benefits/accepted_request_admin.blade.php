@extends('layouts.app')

@section('content')
<div>
    @include('welfare.nav')

    <h4>Solicitudes aceptadas</h4><br>

    <!-- Tabla de Solicitudes -->
    <table class="table table-bordered table-sm" style="table-layout: fixed; width: 100%;">
        <!-- Colgroup para definir el ancho de columnas -->
        <colgroup>
            <col style="width: 5%;">
            <col style="width: 15%;">
            <col style="width: 20%;">
            <col style="width: 25%;">
            <col style="width: 10%;">
            <col style="width: 15%;">
            <col style="width: 25%;">
            <col style="width: 15%;">
        </colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>F. Solicitud</th>
                <th>Solicitante</th>
                <th>Beneficio</th>
                <th>Adjunto</th>
                <th>Acciones</th>
                <th>Monto aprobado</th>
                <th>Notificar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                @livewire('welfare.benefits.accepted-request-row', ['requestId' => $request->id], key($request->id))
            @endforeach
        </tbody>
    </table>


    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $requests->links() }}
    </div>
</div>
@endsection
