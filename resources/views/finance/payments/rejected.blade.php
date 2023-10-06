@extends('layouts.app')
@section('title', 'Flujos de Pago')
@section('content')
    @include('finance.payments.partials.nav')
    <h3 class="mb-3">Bandeja de Pagos Rechazados</h3>

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
                        {{ $dte->confirmationUser->shortName }}:<br>
                        <i class="text-danger">
                            {{ $dte->confirmation_observation }}
                        </i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dtes->links() }}

@endsection
