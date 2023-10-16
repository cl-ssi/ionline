@extends('layouts.bt4.app')

@section('title', 'Listado de Solicitudes de Idoneidad Aprobadas')

@section('content')

    @include('suitability.nav')

    <h3 class="mb-3">Listado de Solicitudes Aprobadas</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Solicitud N°</th>
                <th>Run</th>
                <th>Nombre Completo</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Fecha de Aprobación</th>
                <th>Certificado</th>
                <th>Eliminar Certificado y Volver a generar una nueva solicitud de Firma</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($psirequests as $psirequest)
                <tr>
                    <td>{{ $psirequest->id }}</td>
                    <td>{{ $psirequest->user_id }}</td>
                    <td>{{ $psirequest->user->fullName }}</td>
                    <td>{{ $psirequest->job }}</td>
                    <td>{{ $psirequest->user->email }}</td>
                    <td>{{ $psirequest->status }}</td>
                    <td>{{ $psirequest->updated_at }}</td>
                    <td>
                        @if ($psirequest->result->signedCertificate && $psirequest->result->signedCertificate->hasAllFlowsSigned)
                            <a href="{{ route('suitability.results.signedSuitabilityCertificate', $psirequest->result->id) }}"
                                class="btn @if ($psirequest->result->signedCertificate->hasAllFlowsSigned) btn-outline-success @else btn-outline-primary @endif"
                                target="_blank">
                                <span class="fas fa-file-pdf" aria-hidden="true"></span></a>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('suitability.emergency', ['psirequest' => $psirequest]) }}"
                            onsubmit="return confirm('¿Está seguro de que desea realizar esta acción?')">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <span class="fas fa-fire" aria-hidden="true"></span> Botón de Emergencia
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>

    </table>


    {{ $psirequests->links() }}

@endsection

@section('custom_js')

@endsection
