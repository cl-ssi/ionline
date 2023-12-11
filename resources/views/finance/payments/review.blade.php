@extends('layouts.bt5.app')

@section('title', 'Flujos de Pago')

@section('content')

    @include('finance.payments.partials.nav')

    <h3 class="mb-3">
        Bandeja de Revisión de Pago
    </h3>

    <form action="{{ route('finance.payments.review') }}" method="GET">
        <div class="row g-2 mb-3">
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
                <th>Recepción</th>
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
                        <!-- Nuevo módulo de Recepciones -->
                        @include('finance.payments.partials.receptions-info')
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
                            <i class="fas fa-hand-holding-usd"></i> Listos para Pago
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dtes->links() }}

@endsection
