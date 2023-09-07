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
                <th>Acta Adjunta/Carga de Archivo</th>
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
                    <td>
                        @if ($dte->confirmation_signature_file)
                            <a href="{{ route('warehouse.cenabast.downloadFile', ['dte' => $dte->id]) }}"
                                class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> Descargar Acta
                            </a>
                            <br>
                            <br>
                            <form action="{{ route('warehouse.cenabast.deleteFile', ['dte' => $dte->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro que desea eliminar el acta firmara para el DTE {{ $dte->id }} ?' )">
                                    <i class="fas fa-trash"></i> Borrar Acta
                                </button>
                            </form>
                        @else
                            <form action="{{ route('warehouse.cenabast.saveFile', ['dte' => $dte->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="acta_{{ $dte->id }}">
                                <button class="btn btn-primary btn-sm">Guardar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    {{ $dtes->links() }}

@endsection
