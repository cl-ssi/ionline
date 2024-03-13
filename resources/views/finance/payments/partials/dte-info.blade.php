{{ $dte->emisor }}
<br>
<small>{{ $dte->razon_social_emisor }}</small>
<br>

@switch($dte->tipo_documento)
    @case('factura_electronica')
    @case('factura_exenta')
    @case('guias_despacho')
    @case('nota_debito')
    @case('nota_credito')
        <a 
            href="{{ $dte->uri }}"
            target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
            <i class="fas fa-file-pdf text-danger"></i> 
            {{ $dte->tipo_documento_iniciales }} {{ $dte->folio }}
        </a>
        @break
    @case('boleta_honorarios')
        <a href="{{ $dte->uri }}" target="_blank"
            class="btn btn-sm mb-1 btn-outline-secondary">
            <i class="fas fa-file-pdf text-danger"></i>
            {{ $dte->tipo_documento_iniciales }} {{ $dte->folio }}
        </a>
        @break
    @case('boleta_electronica')
        <a  href="{{ route('finance.dtes.downloadManualDteFile', $dte) }}" target="_blank"
            target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
            <i class="fas fa-file-pdf text-danger"></i>
            {{ $dte->tipo_documento_iniciales }} {{ $dte->folio }}
        </a>
        @break
@endswitch

<hr>

@foreach ($dte->dtes as $dteAsociate)
    @switch($dteAsociate->tipo_documento)
        {{-- @case('factura_electronica') --}}
        {{-- @case('factura_exenta') --}}
        @case('guias_despacho')
        @case('nota_debito')
        @case('nota_credito')
            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dteAsociate->uri }}"
                target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                <i class="fas fa-file-pdf text-danger"></i>
                {{ $dteAsociate->tipo_documento_iniciales }} {{ $dteAsociate->folio }}
            </a>
            @break
        @case('boleta_honorarios')
            <a href="{{ $dteAsociate->uri }}" target="_blank"
                class="btn btn-sm mb-1 btn-outline-secondary">
                <i class="fas fa-file-pdf text-danger"></i>
                {{ $dteAsociate->tipo_documento_iniciales }} {{ $dteAsociate->folio }}
            </a>
            @break
        @case('boleta_electronica')
            @if($dteAsociate->archivo_carga_manual)
                <a  href="{{ route('finance.dtes.downloadManualDteFile', $dteAsociate) }}" target="_blank"
                    target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                    <i class="fas fa-file-pdf text-danger"></i>
                    {{ $dteAsociate->tipo_documento_iniciales }} {{ $dteAsociate->folio }}
                </a>
            @endif
            @break
    @endswitch
    <br>
@endforeach

<!-- Mostrar las facturas asociadas, sólo para algunos tipos de documentos: guias y notas -->
@switch($dte->tipo_documento)
    @case('factura_electronica')
    @case('factura_exenta')
        @break

    @case('guias_despacho')
    @case('nota_debito')
    @case('nota_credito')
        @forelse ($dte->invoices as $invoiceAsociate)
            <!-- Siempre deberían ser facturas de acepta, de lo contrario habrá que poner el switch que está arriba -->
            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $invoiceAsociate->uri }}"
                target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                <i class="fas fa-file-pdf text-danger"></i> 
                {{ $invoiceAsociate->tipo_documento_iniciales }} {{ $invoiceAsociate->folio }}
            </a>
            <br> 
        @empty
            <span class="text-danger">Sin factura asociada</span>
        @endforelse
        @break

    @case('boleta_honorarios')
    @case('boleta_electronica')
        @break
@endswitch