@extends('layouts.app')
@section('title', 'Estados de pago de mis solicitudes')
@section('content')
    <h3 class="mb-3">Estados de pago de Mis Formularios de Requerimientos como Gestor o Administrador</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Folio</th>
                <th>Documentos de Pago</th>
                <th>Acta de ingreso bodega</th>
                <th>Facturas (DTE)</th>
                <th>Adjuntos</th>
                <th>Anexos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requestforms as $requestform)
                <tr>
                    <td>
                        {{ $requestform->id ?? '' }}
                    </td>
                    <td>
                        <a href="{{ route('request_forms.show', $requestform->id) }}">{{ $requestform->folio }}</a>
                        @if ($requestform->father)
                            <br>(<a
                                href="{{ route('request_forms.show', $requestform->father->id) }}">{{ $requestform->father->folio }}</a>)
                        @endif
                    </td>
                    <td>
                        <ul>
                            @foreach ($requestform->paymentDocs as $paymentDoc)
                                <li>{{ $paymentDoc->name ?? '' }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        {{-- Todo el módulo de warehouse ve los permisos de la persona, entonces una persona sin acceso a la bodega no puede ver el acta de recepcion?
                        ¿quitar el permiso --}}
                        @if ($requestform->control)
                            <a href="{{ route('warehouse.control.pdf', [
                                'store' => $requestform->control->store->id,
                                'control' => $requestform->control->id,
                                'act_type' => 'reception',
                            ]) }}"
                                class="btn btn-sm btn-outline-secondary" target="_blank" title="Acta Recepción Técnica">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        @endif
                    </td>
                    <td>
                        <ul>
                            @foreach ($requestform->immediatePurchases as $immediatePurchase)
                                @foreach ($immediatePurchase->dtes as $dte)
                                    <li>
                                        @if ($dte->tipo_documento != 'boleta_honorarios')
                                            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}"
                                                target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                                                ({{ $dte->tipo_documento }})
                                            </a>
                                        @else
                                            <a href="{{ $dte->uri }}" target="_blank"
                                                class="btn btn-sm mb-1 btn-outline-secondary">
                                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                                                ({{ $dte->tipo_documento }})
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </td>

                    <td>

                        @foreach ($requestform->requestFormFiles as $requestFormFile)
                            <a href="{{ route('request_forms.show_file', $requestFormFile) }}"
                                class="list-group-item list-group-item-action py-2 small" target="_blank">
                                <i class="fas fa-file"></i> {{ $requestFormFile->name }} -
                                <i class="fas fa-calendar-day"></i>
                                {{ $requestFormFile->created_at->format('d-m-Y H:i') }}</a>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($requestform->purchasingProcess->details->count() > 0 ? $requestform->purchasingProcess->details : $requestform->purchasingProcess->detailsPassenger as $key => $detail)
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
