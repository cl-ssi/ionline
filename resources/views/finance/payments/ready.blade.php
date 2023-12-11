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
                    <th>Doc. de Pago</th>
                    <th>Adjuntos</th>
                    {{-- Sin Anexos hasta averiguar si son necesarios
                    <th>Anexos</th> --}}
                    <th>Recepcion</th>
                    <th>Estado</th>
                    <th>Folio Sigfe</th>
                    <th>Observaciones</th>
                    <th>Comprobante de licitación de Fondos</th>
                    {{-- <th>Guardar</th> --}}
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
                            <ul>
                                @if ($dte->requestform)
                                    @if ($dte->requestform->father)
                                        @foreach ($dte->requestform->father->paymentDocs as $paymentDoc)
                                            <li>{{ $paymentDoc->name ?? '' }}</li>
                                        @endforeach
                                    @endif

                                    @foreach ($dte->requestform->paymentDocs as $paymentDoc)
                                        <li>{{ $paymentDoc->name ?? '' }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                        <td>
                            @include('finance.payments.partials.fr-files')
                        </td>
                        {{-- 
                        Se comenta la linea de Anexos
                        
                        <td>
                            @if ($dte->requestform && $dte->requestform->purchasingProcess)
                                @foreach ($dte->requestform->purchasingProcess->details->count() > 0 ? $dte->requestform->purchasingProcess->details : $dte->requestform->purchasingProcess->detailsPassenger as $key => $detail)
                                    @if (isset($detail->pivot->tender) && isset($detail->pivot->tender->attachedFiles))
                                        @foreach ($detail->pivot->tender->attachedFiles as $attachedFile)
                                            <a href="{{ route('request_forms.supply.attached_file.download', $attachedFile) }}"
                                                class="list-group-item list-group-item-action py-2" target="_blank">
                                                <i class="fas fa-file"></i> {{ $attachedFile->document_type }}
                                            </a>
                                        @endforeach
                                    @endif

                                    @if (isset($detail->pivot->directDeal) && isset($detail->pivot->directDeal->attachedFiles))
                                        @foreach ($detail->pivot->directDeal->attachedFiles as $attachedFile)
                                            <a href="{{ route('request_forms.supply.attached_file.download', $attachedFile) }}"
                                                class="list-group-item list-group-item-action py-2" target="_blank">
                                                <i class="fas fa-file"></i> {{ $attachedFile->document_type }} </a>
                                        @endforeach
                                    @endif


                                    @if (isset($detail->pivot->immediatePurchase) && isset($detail->pivot->immediatePurchase->attachedFiles))
                                        @foreach ($detail->pivot->immediatePurchase->attachedFiles as $attachedFile)
                                            <a href="{{ route('request_forms.supply.attached_file.download', $attachedFile) }}"
                                                class="list-group-item list-group-item-action py-2" target="_blank">
                                                <i class="fas fa-file"></i> {{ $attachedFile->document_type }} </a>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif

                            @if ($dte->requestform)
                                @if ($dte->requestform->father && $dte->requestform->father->purchasingProcess)
                                    @foreach ($dte->requestform->father->purchasingProcess->details->count() > 0 ? $dte->requestform->father->purchasingProcess->details : $dte->requestform->father->purchasingProcess->detailsPassenger as $key => $detail)
                                        @if (isset($detail->pivot->tender) && isset($detail->pivot->tender->attachedFiles))
                                            @foreach ($detail->pivot->tender->attachedFiles as $attachedFile)
                                                <a href="{{ route('request_forms.supply.attached_file.download', $attachedFile) }}"
                                                    class="list-group-item list-group-item-action py-2" target="_blank">
                                                    <i class="fas fa-file"></i> {{ $attachedFile->document_type }}
                                                </a>
                                            @endforeach
                                        @endif

                                        @if (isset($detail->pivot->directDeal) && isset($detail->pivot->directDeal->attachedFiles))
                                            @foreach ($detail->pivot->directDeal->attachedFiles as $attachedFile)
                                                <a href="{{ route('request_forms.supply.attached_file.download', $attachedFile) }}"
                                                    class="list-group-item list-group-item-action py-2" target="_blank">
                                                    <i class="fas fa-file"></i> {{ $attachedFile->document_type }} </a>
                                            @endforeach
                                        @endif


                                        @if (isset($detail->pivot->immediatePurchase) && isset($detail->pivot->immediatePurchase->attachedFiles))
                                            @foreach ($detail->pivot->immediatePurchase->attachedFiles as $attachedFile)
                                                <a href="{{ route('request_forms.supply.attached_file.download', $attachedFile) }}"
                                                    class="list-group-item list-group-item-action py-2" target="_blank">
                                                    <i class="fas fa-file"></i> {{ $attachedFile->document_type }} </a>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </td> --}}
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
