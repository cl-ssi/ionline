@extends('layouts.bt4.app')

@section('title', 'Flujos de Pago')

@section('content')

    @include('finance.payments.partials.nav')

    <h3 class="mb-3">
        Bandeja de Revisión de Pago
    </h3>

    <form action="{{ route('finance.payments.review') }}" method="GET">
        <div class="form-row mb-3">
            <div class="col-md-1">
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
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estb.</th>
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
                    <td class="small">{{ $dte->establishment?->alias }}</td>
                    <td class="small">
                        @include('finance.payments.partials.dte-info')
                    </td>
                    <td class="small">
                        @livewire('finance.get-purchase-order', ['dte' => $dte], key($dte->id))
                    </td>
                    <td class="small">
                        @include('finance.payments.partials.fr-info')
                    </td>
                    <td class="small">
                        @include('finance.payments.partials.fr-files')
                    </td>
                    <td class="small">
                        <!-- 
                            Acá deben ir tres cosas. 
                            1. Actas de recepción emitidas en el módulo de cenabast
                            2. Actas de recepción emitidas y firmadas en bodega
                            3. Actas de recepción de servicios emitidas en abastecimiento
                        -->

                        <!-- Punto 1 -->
                        @if (isset($dte->confirmation_signature_file) && !isset($dte->cenabast_reception_file))
                            <a 
                                href="{{ route('warehouse.cenabast.downloadFile', ['dte' => $dte->id]) }}"
                                class="btn btn-sm btn-outline-success" 
                                title="Descargar Acta Original"
                                target="_blank"
                            >
                                <i class="fas fa-file"></i> CNB
                            </a>
                        @elseif(isset($dte->cenabast_reception_file))
                            <a 
                                class="btn btn-sm btn-success"
                                href="{{ route('warehouse.cenabast.download.signed', $dte) }}"
                                title="Descargar Acta Firmada"
                                target="_blank"
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
                            <i class="fas fa-hand-holding-usd"></i> Enviar a Listos para Pago
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dtes->links() }}

@endsection
