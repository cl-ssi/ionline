@extends('layouts.bt4.app')

@section('title', 'Ver Consulta')

@section('content')

@include('integrity.partials.nav')

<div class="card">
    <div class="card-body">
        <h3 class="mb-3">Solicitud de Integridad N°: {{ $complaint->type[0] }}{{ $complaint->id }} / 2018</h3>

        <p><strong>Tipo:</strong> {{ $complaint->type }}</p>

        <p><strong>Autor:</strong> {{ $complaint->user ? $complaint->user->fullName : '' }}</p>

        <p><strong>Valor:</strong> {{ $complaint->value->name }} {{ $complaint->other_value }}</p>

        <p><strong>Principio:</strong> {{ $complaint->principle->name }}</p>

        <div class="card">
            <div class="card-body">
                <p><strong>Descripción:</strong><br>
                    {{ $complaint->content }}</p>
            </div>
        </div>

        <br>

        <p><strong>Conoce código de ética:</strong> {{ $complaint->know_code ? 'Sí' : 'No' }}</p>

        <p><strong>Concentimiento de identidad:</strong> {{ $complaint->identify ? 'Sí' : 'No' }}</p>

        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Ingreso</div>
            <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Sobreseimiento</div>
            <div class="progress-bar bg-info" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">Investigación</div>
            <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Sobreseimiento</div>
            <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Formulación de cargos</div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Dictamen Final</div>
        </div>

        <br>

        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
        </div>

    </div>
</div>
@endsection

@section('custom_js')

@endsection
