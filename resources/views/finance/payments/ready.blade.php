@extends('layouts.bt5.app')
@section('title', 'Flujos de Pago')
@section('content')
    @include('finance.payments.partials.nav')
    <h3 class="mb-3">Bandeja listos para pago</h3>

    <form action="{{ route('finance.payments.ready') }}" method="GET">
        <div class="row g-2 mb-3">
            <div class="col-md-2">
                <input type="text" class="form-control" name="id" placeholder="id" value="{{ old('id') }}"
                    autocomplete="off">
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
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Folio OC</th>
                    <th>FR</th>
                    <th>Adjuntos</th>
                    <th>Recepcion</th>
                    <th>Estado</th>
                    <th>Folio Sigfe</th>
                    <th>Observaciones</th>
                    <th>Comprobante de licitación de Fondos</th>
                    @canany(['be god', 'Payments: return to review'])
                        <th>Retornar a Bandeja </th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($dtes as $dte)
                    <tr>
                        <td class="small">{{ $dte->id }}</td>
                        <td>
                            @include('finance.payments.partials.dte-info')
                        </td>
                        <td class="small">
                            {{ $dte->folio_oc }}
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
                        <td>
                            <form action="{{ route('finance.payments.update', ['dte' => $dte->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select class="form-select" name="status" required>
                                    <option value="">Seleccionar Estado
                                    </option>
                                    <option value="Enviado a Pago" @if ($dte->estado == 'Enviado a Pago') selected @endif>
                                        Enviado a
                                        Pago
                                    </option>
                                    <option value="Rechazado" @if ($dte->estado == 'Rechazado') selected @endif>Rechazado
                                    </option>
                                    <option value="Pagado" @if ($dte->estado == 'Pagado') selected @endif>Pagado
                                    </option>
                                </select>

                                <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                            </form>
                        </td>
                        <td>
                            <input type="number" name="folio_sigfe" class="form-control small"
                                value={{ $dte->folio_sigfe }}required>
                        </td>
                        <td>
                            <textarea name="observation" class="form-control">
                                                @foreach ($dte->paymentFlows as $paymentFlow)
{{ $paymentFlow->observation }}
                                                        @if ($paymentFlow->observation)
({{ $paymentFlow->user->short_name }})
@endif
@endforeach
                            </textarea>
                        </td>
                        <td>
                            @livewire('finance.sigfe-archivo-comprobante', ['dte' => $dte], key($dte->id))
                        </td>
                        @canany(['be god', 'Payments: return to review'])
                            <td>
                                <form action="{{ route('finance.payments.returnToReview', ['dte' => $dte->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary"
                                        onclick="return confirm('¿Está seguro que regresar a la bandeja de revisión?, esto solamente deberá realizarlo en caso de error en los datos del DTE')">
                                        <i class="fas fa-arrow-circle-left"></i>
                                    </button>
                                </form>
                            </td>
                        @endcanany
                    </tr>

                @endforeach

            </tbody>
        </table>

        {{ $dtes->links() }}

    </div>
@endsection
