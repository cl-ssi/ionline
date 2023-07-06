@extends('layouts.app')

@section('title', 'Mis Preguntas/Sugerencias Amipass')

@section('content')
    <div class="form-row">
        <div class="col">
            <h3 class="mb-3">Mis Consultas/Sugerencia de Amipass</h3>
        </div>
        <div class="col-3 text-end">
            <button class="btn btn-success float-right">
                <i class="fas fa-plus"></i> Nueva Consulta/Sugerencia
            </button>
        </div>
    </div>


    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha Consulta/Sugerencia</th>
                <th>Motivo</th>
                <th>Consulta o Sugerencia</th>
                <th>Fecha Respuesta</th>
                <th>Respuesta</th>                
            </tr>
        </thead>
    </table>
@endsection
