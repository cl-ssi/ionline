@extends('layouts.bt5.app')

@section('title', 'Estados de pago - Pagados')

@section('content')

@include('finance.payments.partials.nav')

<h3 class="mb-3">Estados de pago</h3>

<h5 class="mb-3">Pagados</h5>

<form action="{{ route('finance.payments.paid') }}" method="GET">
        <div class="row g-2 mb-3">
            <div class="col-md-1">
                <label for="for-id" class="form-label">ID</label>
                <input type="text" class="form-control" name="id" placeholder="id" value="{{ old('id') }}" autocomplete="off">
            </div>
            <div class="col-md-2">
                <label for="for-emisor" class="form-label">Rut</label>
                <input type="text" class="form-control" name="emisor" value="{{ old('emisor') }}" placeholder="rut emisor" id="for_emisor" autocomplete="off">
            </div>
            <div class="col-md-1">
                <label for="for-folio" class="form-label">Folio DTE</label> 
                <input type="text" class="form-control" name="folio" placeholder="folio" value="{{ old('folio') }}">
            </div>
            <div class="col-md-1">
                <label for="for-folio" class="form-label">Folio Comp</label> 
                <input type="text" class="form-control" name="folio_compromiso" placeholder="compromiso" value="{{ old('folio_compromiso') }}">
            </div>
            <div class="col-md-1">
                <label for="for-folio" class="form-label">Folio Dev</label> 
                <input type="text" class="form-control" name="folio_devengo" placeholder="compromiso" value="{{ old('folio_devengo') }}">
            </div>
            <div class="col-md-1">
                <label for="for-folio" class="form-label">Folio Pago</label> 
                <input type="text" class="form-control" name="folio_pago" placeholder="folio_pago" value="{{ old('folio_pago') }}">
            </div>
            <div class="col-md-2">
                <label for="for-folio_oc" class="form-label">Folio OC</label>
                <input type="text" class="form-control" name="oc" placeholder="oc" value="{{ old('oc') }}">
            </div>
            <div class="col-md-1">
                <label for="search" class="form-label">&nbsp;</label>
                <button class="btn btn-outline-secondary form-control" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="col-md-1">
                <div wire:loading>
                    <div class="spinner-border"></div>
                </div>
            </div>
        </div>
</form>



<div class="table-responsive">
        <table class="table table-sm table-bordered">
        <thead class="text-center">
            <tr>
                <th rowspan="2">ID</th>
                <th rowspan="2">Documento</th>
                <th rowspan="2" width="140px">OC</th>
                <th rowspan="2">FR</th>
                <th rowspan="2">Adjuntos</th>
                <th rowspan="2">Recepcion</th>
                <th rowspan="2">SIGFE</th>
                <th colspan="4">Pago</th>
                <th rowspan="2">Observaciones</th>
            </tr>
            <tr>
                <th>Folio</th>
                <th>Fec Gen</th>
                <th>PDF</th>
                <th>Tipo</th>
            </tr>
        </thead>

            <tbody>
                @foreach ($dtes as $dte)
                    <tr>
                        <td class="small">
                            {{ $dte->id }}
                            {{--
                            @livewire('finance.check-tesoreria', ['dte_id' => $dte->id], key($dte->id))
                            --}}
                        </td>
                        <td>
                            @include('finance.payments.partials.dte-info')
                        </td>
                        <td class="small">
                        @livewire('finance.get-purchase-order', ['dte' => $dte], key($dte->id))
                        </td>
                        <td>
                            @include('finance.payments.partials.fr-info')
                        </td>
                        <td>
                            @include('finance.payments.partials.fr-files')
                        </td>
                        <td>
                            <!-- Nuevo módulo de Recepciones -->
                            @include('finance.payments.partials.receptions-info')
                        </td>
                        <td class="small">
                            <small>Compromiso</small>
                            @livewire('finance.sigfe-folio-compromiso', 
                            [
                                'dte' => $dte,
                                'onlyRead' => 'true'
                            ],
                            key($dte->id))
                            @livewire('finance.sigfe-archivo-compromiso', 
                            [
                                'dte' => $dte,
                                'onlyRead' => 'true'
                                ], key($dte->id))
                            <hr>
                            <small>Devengo</small>
                            @livewire('finance.sigfe-folio-devengo', [
                                'dte' => $dte,
                                'onlyRead' => 'true'
                            ], key($dte->id))
                            <hr>
                            @livewire('finance.sigfe-archivo-devengo', 
                            [
                                'dte' => $dte,
                                'onlyRead' => 'true'
                            ], key($dte->id))

                        </td>
                        <td>{{$dte->tgrPayedDte?->folio}}</td>
                        <td nowrap><small>{{$dte->tgrPayedDte ? $dte->tgrPayedDte->fecha_generacion->format('d-m-Y') : ''}}</small></td>
                        <td>
                        <a href="{{ route('finance.payments.paidPdf', ['dte' => $dte]) }}" class="btn btn-sm btn-outline-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>

                        <td>
                            @if($dte->paid_automatic)
                                <span title="Pago automático"><i class="fas fa-money-check-alt"></i></span>
                            @endif

                            @if($dte->paid_manual)
                                <span title="Pago manual"><i class="fas fa-hand-holding-usd"></i></span>
                            @endif
                        </td>

                        <td>
                            @livewire('finance.dte-observations', ['dte' => $dte], key($dte->id))
                        </td>

                    </tr>

                @endforeach

            </tbody>
        </table>

        {{ $dtes->appends(request()->query())->links() }}

    </div>

@endsection