@extends('layouts.bt5.app')
@section('title', 'Bandeja Pendiente para Pago')
@section('content')
    @include('finance.payments.partials.nav')
    <h3 class="mb-3">Bandeja Pendiente para Pago</h3>

    <form action="{{ route('finance.payments.ready') }}" method="GET">
        <div class="row g-2 mb-3">
            <div class="col-md-1">
                <label for="for-id" class="form-label">ID</label>
                <input type="text" class="form-control" name="id" placeholder="id" value="{{ old('id') }}" autocomplete="off">
            </div>
            <div class="col-md-2">
                <label for="for-emisor" class="form-label">Rut</label>
                <input type="text" class="form-control" name="emisor" value="{{ old('emisor') }}" placeholder="rut emisor">
            </div>
            <div class="col-md-1">
                <label for="for-folio" class="form-label">Folio DTE</label> 
                <input type="text" class="form-control" name="folio" placeholder="folio" value="{{ old('folio') }}">
            </div>
            <div class="col-md-2">
                <label for="for-folio_oc" class="form-label">Folio OC</label>
                <input type="text" class="form-control" name="oc" placeholder="oc" value="{{ old('oc') }}">
            </div>
            <div class="col-md-1">
                <label for="for-prov" class="form-label">Prov</label>
                <select class="form-select" name="prov">
                <option value="Todos" {{ old('prov') == 'Todos' ? 'selected' : '' }}>Todos</option>
                <option value="Con" {{ old('prov') == 'Con' ? 'selected' : '' }}>Con</option>
                <option value="Sin" {{ old('prov') == 'Sin' ? 'selected' : '' }}>Sin</option>
                </select>
            </div>
            <div class="col-md-1">
                <label for="for-cart" class="form-label">Cart</label>
                <select class="form-select" name="cart">
                    <option value="Todos" {{ old('cart') == 'Todos' ? 'selected' : '' }}>Todos</option>
                    <option value="Con" {{ old('cart') == 'Con' ? 'selected' : '' }}>Con</option>
                    <option value="Sin" {{ old('cart') == 'Sin' ? 'selected' : '' }}>Sin</option>
                </select>
            </div>
            <div class="col-md-1">
                <label for="for-req" class="form-label">Req</label>
                <select class="form-select" name="req">
                    <option value="Todos" {{ old('req') == 'Todos' ? 'selected' : '' }}>Todos</option>
                    <option value="Con" {{ old('req') == 'Con' ? 'selected' : '' }}>Con</option>
                    <option value="Sin" {{ old('req') == 'Sin' ? 'selected' : '' }}>Sin</option>
                </select>
            </div>
            <div class="col-md-2">
                <!-- <label for="for-tipo_documento" class="form-label">Tipo Documento</label>
                <select class="form-select" wire:model.defer="filter.tipo_documento">
                    <option value="">Todas</option>
                    <option value="factura_electronica">FE: Factura Electrónica</option>
                    <option value="factura_exenta">FE: Factura Exenta</option>
                    <option value="guias_despacho">GD: Guias Despacho</option>
                    <option value="nota_credito">NC: Nota Crédito</option>
                    <option value="boleta_honorarios">BH: Boleta Honorarios</option>
                    <option value="boleta_electronica">BE: Boleta Electrónica</option>
                </select> -->
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

    <!-- <form action="{{ route('finance.payments.ready') }}" method="GET">
        <div class="row g-2 mb-3">
            <div class="col-md-1">
                <input type="text" class="form-control" name="id" placeholder="id" value="{{ old('id') }}"
                    autocomplete="off">
            </div>
            <div class="col-md-2">            
                <input type="text" class="form-control" name="emisor" value="{{ old('emisor') }}" placeholder="rut emisor">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="folio" placeholder="folio" value="{{ old('folio') }}"
                    autocomplete="off">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="oc" placeholder="oc" value="{{ old('oc') }}"
                    autocomplete="off">
            </div>
            <div class="col-md-1">
                <input class="btn btn-outline-secondary" type="submit" value="Buscar">
            </div>
        </div>
    </form> -->

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
                <th colspan="3">Cargas Excel</th>
                <th rowspan="2">Observaciones</th>
            </tr>
            <tr>
                <th>Prov.</th>
                <th>Cart.</th>
                <th>Req.</th>
            </tr>
        </thead>

            <tbody>
                @foreach ($dtes as $dte)
                    <tr>
                        <td class="small">
                            {{ $dte->id }}
                            <br>
                            @canany(['be god', 'Payments: return to review'])
                                <form action="{{ route('finance.payments.returnToReview', ['dte' => $dte->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            onclick="return confirm('¿Está seguro que regresar a la bandeja de revisión?, esto solamente deberá realizarlo en caso de error en los datos del DTE')">
                                            <i class="fas fa-arrow-circle-left"></i>
                                        </button>
                                </form>
                            @endcanany
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
                        <td class="text-center">
                            @if ($dte->excel_proveedor)
                                <i class="fas fa-check-circle text-success"></i>
                            @else
                                <i class="fas fa-times-circle text-danger"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($dte->excel_cartera)
                                <i class="fas fa-check-circle text-success"></i>
                            @else
                                <i class="fas fa-times-circle text-danger"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($dte->excel_requerimiento)
                                <i class="fas fa-check-circle text-success"></i>
                            @else
                                <i class="fas fa-times-circle text-danger"></i>
                            @endif
                        </td>
                        <td>
                            @livewire('finance.dte-observations', ['dte' => $dte], key($dte->id))
                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>

        {{ $dtes->links() }}

    </div>
@endsection


@section('custom_js')

@endsection