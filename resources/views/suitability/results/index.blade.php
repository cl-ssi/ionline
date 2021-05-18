@extends('layouts.app')

@section('content')

@include('suitability.nav')
<h3 class="mb-3">Listado de Resultados</h3>

<table class="table">
    <thead>
        <tr>
            <th>Contador</th>
            <th>ID</th>
            <th>Colegio</th>
            <th>Solicitud N°</th>            
            <th>Nombre</th>            
            <th>Cargo</th>
            <th>Total de Puntos</th>
            <th>Hora de Termino de Test</th>
            <th>Estado</th>
            <th>Ver Test</th>
            <th>Ver Certificado (Aprobados)</th>
            @can('be god')  <th>Enviar a Firma</th> @endcan
            <th>Descargar PDF (Aprobados)</th>
            <!-- <th>Enviar por Mail </th> -->
        </tr>
    </thead>
    <tbody>
        @foreach($results as $key => $result)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $result->id ?? '' }}</td>
            <td>{{ $result->psirequest->school->name ?? ''  }}</td>
            <td>{{ $result->request_id ?? '' }}</td>
            <td>{{ $result->user->fullName ?? ''  }}</td>            
            <td>{{ $result->psirequest->job ?? ''  }}</td>
            <td>{{ $result->total_points ?? '' }}</td>
            <td>{{ $result->created_at ?? '' }}</td>
            <td>{{ $result->psirequest->status ?? '' }}</td>
            <td>
                <a href="{{ route('suitability.results.show', $result->id) }}" class="btn btn-outline-primary">
                    <span class="fas fa-edit" aria-hidden="true"></span></a>
            </td>
            <td>@if($result->psirequest && $result->psirequest->status =="Aprobado")
                <a href="{{ route('suitability.results.certificate', $result->id) }}" class="btn btn-outline-primary">
                    <span class="fas fa-stamp" aria-hidden="true"></span></a>
                @endif
            </td>
            @can('be god')
            <td>
                @if($result->psirequest && $result->psirequest->status =="Aprobado" && $result->signed_certificate_id === null)
                    <a href="{{ route('suitability.sendForSignature', $result->id) }}" class="btn btn-outline-primary">
                        <span class="fas fa-signature" aria-hidden="true"></span></a>
                @endif
            </td>
            @endcan
            <td>
                @if($result->psirequest && $result->psirequest->status =="Aprobado")

                   @if($result->signedCertificate && $result->signedCertificate->hasSignedFlow)
                        <a href="{{ route('suitability.results.signedSuitabilityCertificate', $result->id) }}"
                           class="btn @if($result->signedCertificate->hasAllFlowsSigned) btn-outline-success @else btn-outline-primary @endif" target="_blank">
                            <span class="fas fa-file-pdf" aria-hidden="true"></span></a>
                    @else

                        <a href="{{ route('suitability.results.certificatepdf', $result->id) }}" class="btn btn-outline-primary">
                            <span class="fas fa-file-pdf" aria-hidden="true"></span></a>
                    @endif
                @endif
            </td>
            <!-- <td>
                Correo
            </td> -->
        </tr>
        @endforeach
    </tbody>

</table>

@endsection

@section('custom_js')


@endsection
