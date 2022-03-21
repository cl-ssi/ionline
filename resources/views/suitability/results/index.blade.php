@extends('layouts.app')

@section('content')

@include('suitability.nav')
<h3 class="mb-3">Listado de Resultados</h3>

<form method="GET" class="form-horizontal" action="{{ route('suitability.results.index') }}">

    <div class="form-row">
        <fieldset class="form-group col-6 col-md-6">
            <label for="for_year">Colegios</label>
            <select name="colegio" class="form-control selectpicker" data-live-search="true">
                <option value="">Todos Los Colegios</option>
                @foreach($schools as $school)
                <option value="{{$school->id}}" @if($school_id==$school->id) selected @endif >{{$school->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-2">
            <label for="for_year">Estados</label>
            <select name="estado" class="form-control selectpicker">
                <option value="">Todos los estados</option>
                @php($states = array('Aprobado', 'Rechazado', 'Test Finalizado'))
                @foreach($states as $state)
                <option value="{{$state}}" @if(isset($estado) && $estado==$state) selected @endif>{{$state}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>

    </forn>

    <table class="table">
        <thead>
            <tr>
                <th>Contador</th>
                <th>ID</th>
                <th>Colegio</th>
                <th>Solicitud N°</th>
                <th>Nombre</th>
                <th>Rut</th>
                <th>Cargo</th>
                <th>Total de Puntos</th>
                <th>Hora de Termino de Test</th>
                <th>Estado <a tabindex="0" role="button" data-toggle="popover" data-trigger="hover" data-html="true" title="" data-content="Aprobados:  {{$count['Aprobado'] ?? 0}} <br> Esperando Test: {{$count['Esperando Test'] ?? 0}} <br> Test Finalizados: {{$count['Test Finalizado'] ?? 0}}">
                        <i class="fas fa-info-circle" aria-hidden="true"></i></a></th>
                <th>Ver Test</th>
                <th>Eliminar Resultado</th>
                <!-- <th>Ver Certificado (Aprobados)</th> -->
                <!-- <th>Enviar a Firmar</th> -->
                <!-- <th>Descargar PDF (Aprobados)</th> -->
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
                <td nowrap>{{ $result->user->runFormat() ?? ''  }}</td>
                <td>{{ $result->psirequest->job ?? ''  }}</td>
                <td>{{ $result->total_points ?? '' }}</td>
                <td>{{ $result->updated_at ?? '' }}</td>
                <td>{{ $result->psirequest->status ?? '' }}</td>
                <td>
                    <a href="{{ route('suitability.results.show', $result->id) }}" class="btn btn-outline-primary">
                        <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
                <td>
                    <form method="POST" action="{{ route('suitability.results.destroy', $result->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este resultado, recuerde que solo debe de eliminar si el resultado se encuentra duplicado?')">
                            <span class="fas fa-trash-alt" aria-hidden="true"></span>
                        </button>
                    </form>

                </td>
                <!-- <td>@if($result->psirequest && $result->psirequest->status =="Aprobado")
                    <a href="{{ route('suitability.results.certificate', $result->id) }}" class="btn btn-outline-primary">
                        <span class="fas fa-stamp" aria-hidden="true"></span></a>
                    @endif
                </td> -->

                <!-- <td>
                    @if($result->psirequest && $result->psirequest->status =="Aprobado" && $result->signed_certificate_id === null)
                    <a href="{{ route('suitability.sendForSignature', $result->id) }}" class="btn btn-outline-primary">
                        <span class="fas fa-signature" aria-hidden="true"></span></a>
                    @endif
                </td> -->

                <!-- <td>
                    @if($result->psirequest && $result->psirequest->status =="Aprobado")

                    @if($result->signedCertificate && $result->signedCertificate->hasSignedFlow)
                    <a href="{{ route('suitability.results.signedSuitabilityCertificate', $result->id) }}" class="btn @if($result->signedCertificate->hasAllFlowsSigned) btn-outline-success @else btn-outline-primary @endif" target="_blank">
                        <span class="fas fa-file-pdf" aria-hidden="true"></span></a>
                    @else

                    <a href="{{ route('suitability.results.certificatepdf', $result->id) }}" class="btn btn-outline-primary">
                        <span class="fas fa-file-pdf" aria-hidden="true"></span></a>
                    @endif
                    @endif
                </td> -->
                <!-- <td>
                Correo
            </td> -->
            </tr>
            @endforeach
        </tbody>

    </table>

    @endsection

    @section('custom_js')
    <script>
        $(function() {
            $('[data-toggle="popover"]').popover()
        })
    </script>

    @endsection