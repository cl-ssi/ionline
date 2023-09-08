@extends('layouts.app')
@section('title', 'Flujos de Pago')
@section('content')
    @include('finance.nav')
    <h3 class="mb-3">Bandeja de Pendientes de Pago</h3>

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
                    <th>Anexos</th>
                    <th>Bod</th>
                    <th>Estado</th>
                    <th>Folio Sigfe</th>
                    <th>Observaciones</th>
                    <th>Guardar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dtes as $dte)
                    <tr>
                        <td class="small">{{ $dte->id }}</td>
                        <td>
                            {{ $dte->tipo_documento }}
                            <br>
                            {{ $dte->emisor }}
                            <br>
                            @if ($dte->tipo_documento != 'boleta_honorarios')
                                <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}"
                                    target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                    <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                                </a>
                            @else
                                <a href="{{ $dte->uri }}" target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                    <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                                </a>
                            @endif
                        </td>
                        <td class="small">
                            {{ $dte->folio_oc }}
                        </td>
                        <td>
                            @if ($dte->requestform)
                                <a
                                    href="{{ route('request_forms.show', $dte->requestform->id) }}">{{ $dte->requestform->folio }}</a>
                                @if ($dte->requestform->father)
                                    <br>(<a
                                        href="{{ route('request_forms.show', $dte->requestform->father->id) }}">{{ $dte->requestform->father->folio }}</a>)
                                @endif
                            @endif
                        </td>
                        <td>
                            <ul>
                                @if ($dte->requestform)
                                    @if ($dte->requestform->father)
                                        @foreach ($dte->requestform->father->paymentDocs as $paymentDoc)
                                            <li>{{ $paymentDoc->name ?? '' }}</li>
                                        @endforeach
                                    @else
                                        @foreach ($dte->requestform->paymentDocs as $paymentDoc)
                                            <li>{{ $paymentDoc->name ?? '' }}</li>
                                        @endforeach
                                    @endif
                                @endif
                            </ul>
                        </td>
                        <td>
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
                        </td>
                        <td>
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
                        <td>
                            <form action="{{ route('finance.payments.update', ['dte' => $dte->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" required>
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
                        </td>
                        <td>
                            <input type="number" name="folio_sigfe" class="form-input"
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
                            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                            </form>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

        {{ $dtes->links() }}

    </div>
@endsection
