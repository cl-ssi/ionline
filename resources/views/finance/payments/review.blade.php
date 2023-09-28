@extends('layouts.app')

@section('title', 'Flujos de Pago')

@section('content')

    @include('finance.nav')

    <h3 class="mb-3">
        Bandeja de Revisión de Pago
    </h3>

    <form action="{{ route('finance.payments.review') }}" method="GET">
        <div class="form-row mb-3">
            <div class="col-md-2">
                <input type="text" class="form-control" name="id" placeholder="id" value="{{ old('id') }}" autocomplete="off">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="folio" placeholder="folio" value="{{ old('folio') }}" autocomplete="off">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="oc" placeholder="oc" value="{{ old('oc') }}" autocomplete="off">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="folio_compromiso" placeholder="folio compromiso SIGFE" value="{{ old('folio_compromiso') }}" autocomplete="off">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="folio_devengo" placeholder="folio devengo SIGFE" value="{{ old('folio_devengo') }}" autocomplete="off">
            </div>
            <div class="col-md-1">
                <input class="btn btn-outline-secondary" type="submit" value="Buscar">
            </div>
        </div>
    </form>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Establecimiento</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Adjuntos</th>
                <th>Bod/Recep</th>
                <th>Compromiso SIGFE</th>
                <th>Devengo SIGFE</th>
                <th>Revisar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
                <tr>
                    <td class="small">{{ $dte->id }}</td>
                    <td class="small">{{ $dte->establishment?->name }}</td>
                    <td class="small">
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
                        @livewire('finance.get-purchase-order', ['dte' => $dte], key($dte->id))
                    </td>
                    <td class="small">
                        @if ($dte->requestForm)
                            <a class="btn btn-outline-primary btn-block"
                                href="{{ route('request_forms.show', $dte->requestForm->id) }}" target="_blank">
                                <i class="fas fa-file-alt"></i> {{ $dte->requestForm->folio }}
                            </a>
                        @endif
                    </td>
                    <td class="small">
                        @if ($dte->requestform)
                            @if ($dte->requestform->father)
                                @foreach ($dte->requestform->father->requestFormFiles as $requestFormFile)
                                    <a href="{{ route('request_forms.show_file', $requestFormFile) }}"
                                        class="list-group-item list-group-item-action py-2 small" target="_blank">
                                        <i class="fas fa-file"></i> {{ $requestFormFile->name }} -
                                        <i class="fas fa-calendar-day"></i>
                                        {{ $requestFormFile->created_at->format('d-m-Y H:i') }}</a>
                                @endforeach
                            @else
                                @foreach ($dte->requestform->requestFormFiles as $requestFormFile)
                                    <a href="{{ route('request_forms.show_file', $requestFormFile) }}"
                                        class="list-group-item list-group-item-action py-2 small" target="_blank">
                                        <i class="fas fa-file"></i> {{ $requestFormFile->name }} -
                                        <i class="fas fa-calendar-day"></i>
                                        {{ $requestFormFile->created_at->format('d-m-Y H:i') }}</a>
                                @endforeach
                            @endif
                        @endif
                    </td>
                    <td class="small">
                        <!-- 
                            Acá deben ir tres cosas. 
                            1. Actas de recepción emitidas en el módulo de cenabast
                            2. Actas de recepción emitidas y firmadas en bodega
                            3. Actas de recepción de servicios emitidas en abastecimiento
                        -->

                        <!-- Punto 1 -->
                        @if($dte->cenabast_reception_file)
                            <a
                                class="btn btn-sm btn-outline-primary" target="_blank" 
                                href="{{ route('warehouse.cenabast.download.signed', $dte) }}"
                                title="Acta de recepción CENABAST"
                            >
                                <i class="fas fa-file"></i> CNB
                            </a>
                        @endif

                        <!-- Punto 2 -->
                        <!-- Punto 3 -->

                        <!-- Esto ya no debería ir -->
                        @foreach ($dte->controls as $control)
                        <a href="{{ route('warehouse.control.show', [
                                'store' => $control->store->id,
                                'control' => $control->id,
                                'act_type' => 'reception',
                            ]) }}"
                                class="btn btn-sm btn-outline-secondary" target="_blank" title="Acta Recepción Técnica">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        @endforeach
                    </td>
                    <td class="small">
                        @livewire('finance.sigfe-folio-compromiso', ['dte' => $dte], key($dte->id))
                        <hr>
                        @livewire('finance.sigfe-archivo-compromiso', ['dte' => $dte], key($dte->id))
                    </td>
                    <td class="small">
                        @livewire('finance.sigfe-folio-devengo', ['dte' => $dte], key($dte->id))
                        <hr>
                        @livewire('finance.sigfe-archivo-devengo', ['dte' => $dte], key($dte->id))
                    </td>
                    <td class="small">
                        <a href="{{ route('finance.payments.sendToReadyInbox', ['dte' => $dte->id]) }}"
                            class="btn btn-sm btn-outline-success">
                            <i class="fas fa-hand-holding-usd"></i> Enviar a Bandeja Pendiente para Pago
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dtes->links() }}

@endsection
