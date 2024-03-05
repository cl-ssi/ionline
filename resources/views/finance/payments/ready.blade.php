@extends('layouts.bt5.app')
@section('title', 'Bandeja Pendiente para Pago')
@section('content')
    @include('finance.payments.partials.nav')
    <h3 class="mb-3">Bandeja Pendiente para Pago</h3>

    <form action="{{ route('finance.payments.ready') }}" method="GET">
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