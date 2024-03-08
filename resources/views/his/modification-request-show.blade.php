@extends('layouts.document')

@section('title', 'iOnline - Solicitud modificación ficha clínica')

@section('linea1', auth()->user()->organizationalUnit->name)

@section('linea3', auth()->user()->organizationalUnit->establishment->name)

@section('content')

<style>
    .etiqueta {
        display: inline-block; /* Permite establecer un ancho fijo */
        width: 120px; /* Ancho fijo deseado */
        font-weight: bold;
    }

    .valor {
        /* Estilos para el contenido */
        display: inline-block; /* Permite establecer un ancho fijo */
    }
</style>

<div style="clear: both;padding-top: 170px;"></div>

<div class="center diez" style="text-transform: uppercase;">
    <strong style="text-transform: uppercase;">
    SOLICITUD DE MODIFICACIÓN DE FICHA CLÍNICA Nº {{ $modificationRequest->id }}
    </strong>
</div>

<div style="clear: both; padding-bottom: 20px"></div>

<br>

<span class="etiqueta">Fecha de solicitud:</span>
<span class="valor">{{ $modificationRequest->created_at }}</span><br>

<span class="etiqueta">Solicitante:</span>
<span class="valor">{{ $modificationRequest->creator->shortName }}</span><br>

<span class="etiqueta">Tipo de solicitud:</span>
<span class="valor">{{ $modificationRequest->type }}</span><br>

<span class="etiqueta">Asunto:</span>
<span class="valor">{{ $modificationRequest->subject }}</span><br>

<span class="etiqueta">Detalle:</span>
<span class="valor" style="white-space: pre-wrap;">{{ $modificationRequest->body }}</span>

@endsection

@section('approvals')
    <!-- Sección de las aprobaciones -->
    <div class="signature-footer">
        @foreach($modificationRequest->approvals as $approval)

        <div class="signature">
            @include('sign.approvation', [
                'approval' => $approval
            ])
        </div>
        
        @endforeach
    </div>
@endsection