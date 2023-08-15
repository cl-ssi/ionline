@extends('layouts.app')
@section('title', 'Cenabast')
@section('content')
    @include('warehouse.stores.cenabast.nav')

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th>Bod</th>
                <th>Fecha Aceptación SII (días)</th>
                <th>Establecimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
                <tr>
                    <td>{{ $dte->id }}</td>
                    <td>
                        @if ($dte->tipo_documento != 'boleta_honorarios')
                            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}" target="_blank"
                                class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @else
                            <a href="{{ $dte->uri }}" target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @endif
                        <br>
                        {{ $dte->tipo_documento }}
                        <br>
                        {{ $dte->emisor }}
                    </td>
                    <td class="small">
                        @foreach ($dte->controls as $control)
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('warehouse.control.show', $control) }}"
                                target="_blank">
                                #{{ $control->id }}
                            </a>
                        @endforeach
                    </td>
                    <td>
                        {{ $dte->fecha_recepcion_sii ?? '' }} <br>
                        ({{ $dte->fecha_recepcion_sii ? $dte->fecha_recepcion_sii->diffInDays(now()) : '' }} días)
                    </td>
                    <td>{{ $dte->establishment->name ?? '' }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

@endsection
