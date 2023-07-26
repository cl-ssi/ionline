@extends('layouts.app')
@section('title', 'Flujos de Pago')
@section('content')
    <h3 class="mb-3">
        Flujos de pago de Finanzas</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>DTEs</th>
                <th>OC</th>
                <th>Folio FR</th>
                <th>Documentos de Pago</th>
                <th>Adjuntos</th>
                <th>Anexos</th>
                <th>Acta de ingreso bodega</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Guardar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
                <tr>
                    <td>
                        @if ($dte->tipo_documento != 'boleta_honorarios')
                            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}" target="_blank"
                                class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                                <small>({{ $dte->tipo_documento ?? '' }})</small>
                            </a>
                        @else
                            <a href="{{ $dte->uri }}" target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                                ({{ $dte->tipo_documento ?? '' }})
                            </a>
                        @endif
                    </td>
                    <td>{{ $dte->folio_oc ?? '' }}
                    <td>
                        <a
                            href="{{ route('request_forms.show', $dte->requestform->id) }}">{{ $dte->requestform->folio }}</a>
                        @if ($dte->requestform->father)
                            <br>(<a
                                href="{{ route('request_forms.show', $dte->requestform->father->id) }}">{{ $dte->requestform->father->folio }}</a>)
                        @endif
                    </td>
                    <td>
                        <ul>
                            @if ($dte->requestform->father)
                                @foreach ($dte->requestform->father->paymentDocs as $paymentDoc)
                                    <li>{{ $paymentDoc->name ?? '' }}</li>
                                @endforeach
                            @else
                                @foreach ($dte->requestform->paymentDocs as $paymentDoc)
                                    <li>{{ $paymentDoc->name ?? '' }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </td>
                    <td>
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
                                <option value="Enviado a Pago" @if ($dte->estado == 'Enviado a Pago') selected @endif>Enviado a
                                    Pago
                                </option>
                                <option value="Rechazado" @if ($dte->estado == 'Rechazado') selected @endif>Rechazado
                                </option>
                                <option value="Pagado" @if ($dte->estado == 'Pagado') selected @endif>Pagado</option>
                            </select>                        
                    </td>
                    <td>
                        @foreach ($dte->paymentFlows as $paymentFlow)
                            <p>{{ $paymentFlow->observation }} @if ($paymentFlow->observation)
                                    ({{ $paymentFlow->user->short_name }})
                                @endif
                            </p>
                        @endforeach
                        <textarea name="observation"></textarea>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                        </form>
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
