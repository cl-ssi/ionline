@extends('layouts.bt4.app')
@section('title', 'Flujos de Pago')
@section('content')
    @include('finance.payments.partials.nav')
    <h3 class="mb-3">Bandeja de Pagos Rechazados</h3>

    <form action="{{ route('finance.payments.rejected') }}" method="GET">
        <div class="row g-2 mb-3">
            <div class="col-md-2">
                <input type="text" class="form-control" name="id" placeholder="id" value="{{ old('id') }}" autocomplete="off">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="folio" placeholder="folio" value="{{ old('folio') }}" autocomplete="off">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="folio_oc" placeholder="folio_oc" value="{{ old('folio_oc') }}" autocomplete="off">
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
                <th>Estab.</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Rechazo</th>
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
                        {{ $dte->confirmation_at }} <br>
                        {{ $dte->confirmationUser->shortName ?? '' }}<br>
                        <i class="text-danger">
                            {{ $dte->reason_rejection }}
                        </i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dtes->links() }}

@endsection
