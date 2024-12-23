@extends('layouts.app')

@section('content')
<div>
    @include('welfare.nav')

    <h4>Administrador de Solicitudes</h4>

    <br>

    <!-- Filtros -->
    <form method="GET" action="{{ route('welfare.benefits.requests-admin') }}">
        <div>
            <label>
                <input type="checkbox" name="statusFilters[]" value="En revisión" 
                    {{ in_array('En revisión', $statusFilters) ? 'checked' : '' }}> En revisión
            </label>
            <label>
                <input type="checkbox" name="statusFilters[]" value="Aceptado" 
                    {{ in_array('Aceptado', $statusFilters) ? 'checked' : '' }}> Aceptado
            </label>
            <label>
                <input type="checkbox" name="statusFilters[]" value="Rechazado" 
                    {{ in_array('Rechazado', $statusFilters) ? 'checked' : '' }}> Rechazado
            </label>
            <label>
                <input type="checkbox" name="statusFilters[]" value="Pagado" 
                    {{ in_array('Pagado', $statusFilters) ? 'checked' : '' }}> Pagado
            </label>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <br>

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
                @livewire('welfare.benefits.request-row', ['requestId' => $request->id], key($request->id))
            @endforeach
        </tbody>
    </table>


    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $requests->links() }}
    </div>
</div>
@endsection
