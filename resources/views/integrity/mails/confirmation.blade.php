@extends('layouts.mail')

@section('content')

<strong>COMPROBANTE DE INGRESO DE NUEVO REGISTRO</strong><br><br>
<strong>MÓDULO DE INTEGRIDAD Y ÉTICA</strong><br><br>
<hr>
<div class="justify">
    <div class="card">
        <div class="card-body">
            <p>Se ha recepcionado con fecha {{ $complaint->created_at->format('d-m-Y') }} a las {{ $complaint->created_at->format('H:i') }} en el sistema de integridad una nueva solicitud para su gestión.</p>

            <h3 class="mb-3">Solitud de Integridad N°: {{ $complaint->type[0] }}{{ $complaint->id }} / 2018</h3>

            <p><strong>Tipo:</strong> {{ $complaint->type }}</p>

            <p><strong>Autor:</strong> {{ $complaint->email }} ({{ $complaint->user_id }})</p>

            <p><strong>Valor:</strong> {{ $complaint->value->name }}</p>

            <p><strong>Principio:</strong> {{ $complaint->principle->name }}</p>

            <div class="card">
                <div class="card-body">
                    <p>
                        <strong>Descripción:</strong><br>
                        {{ $complaint->content }}
                    </p>
                </div>
            </div>

            <br>

            <p><strong>Conoce código de ética:</strong> {{ $complaint->know_code ? 'Sí' : 'No' }}</p>

            <p><strong>Reserva de identidad:</strong> {{ $complaint->identify ? 'Sí' : 'No' }}</p>

        </div>
    </div>
</div>

@endsection

@section('firmante', 'SSI Intranet')

@section('linea1', 'Módulo de integridad y ética')

@section('linea2', 'Unidad de Informática y Tecnología')

@section('linea3', 'sistemas.ssi@redsalud.gob.cl')
