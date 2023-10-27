@extends('layouts.bt4.app')
@section('title', 'Visación Administrador de Contrato')
@section('content')
    @include('warehouse.visations.contract_manager.nav')

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th>Orden de Compra</th>
                <th>Formulario de Requerimiento</th>
                @if (!$tray)
                    <th>Aceptar</th>
                    <th>Rechazar</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($controls as $control)
                <tr>
                    <td>{{ $control->id }}</td>
                    {{--  Preguntar la relación con documento si va o no --}}
                    <td></td>
                    <td>{{ $control->po_code }}</td>
                    <td>
                        @if ($control->requestForm)
                            <a href="{{ route('request_forms.show', $control->requestForm->id) }}" target="_blank">
                                {{ $control->requestForm->folio }}
                            </a>
                            <br>
                            @if ($control->requestForm->signatures_file_id)
                                <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado"
                                    href="{{ $control->requestForm->signatures_file_id == 11
                                        ? route('request_forms.show_file', $control->requestForm->requestFormFiles->last() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$control->requestForm, 1]) }}"
                                    target="_blank" title="Certificado">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif

                            @if ($control->requestForm->old_signatures_file_id)
                                <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anterior firmado"
                                    href="{{ $control->requestForm->old_signatures_file_id == 11
                                        ? route('request_forms.show_file', $control->requestForm->requestFormFiles->last() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$control->requestForm, 0]) }}"
                                    target="_blank" title="Certificado">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif

                            @if ($control->requestForm->signedOldRequestForms->isNotEmpty())
                                <a class="btn btn-secondary btn-sm"
                                    title="Ver Formulario de Requerimiento Anteriores firmados"
                                    href="{{ $control->requestForm->old_signatures_file_id == 11
                                        ? route('request_forms.show_file', $control->requestForm->requestFormFiles->last() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$control->requestForm, 0]) }}"
                                    target="_blank" data-toggle="modal"
                                    data-target="#history-fr-{{ $control->requestForm->id }}">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif
                        @endif
                    </td>
                    @if (!$tray)
                        <td>
                            <form action="{{ route('warehouse.visation_contract_manager.accept', $control) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Aceptar">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#rejectSignature{{ $control->id }}" title="Rechazar">
                                <i class="fas fa-times"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="rejectSignature{{ $control->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Motivo de Rechazo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" class="form-horizontal"
                                            action="{{ route('warehouse.visation_contract_manager.reject', $control->id) }}"
                                            enctype="multipart/form-data" id="rejectForm{{ $control->id }}">
                                            <div class="modal-body">
                                                @csrf
                                                @method('POST')
                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label for="forobservacion">Motivo de Rechazo</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="forobservacion" name="observacion" maxlength="255"
                                                            autocomplete="off" form="rejectForm{{ $control->id }}"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    type="submit">Enviar</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Icono de Rechazar -->
                            {{-- <button type="button" class="btn btn-danger btn-sm" title="Rechazar"
                                data-target="#rejectSignature{{ $control->id }}">
                                <i class="fas fa-times"></i>
                            </button> --}}
                        </td>
                        {{-- Modal rechazo --}}
                        {{-- <div class="modal fade" id="rejectSignature{{ $control->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Rechazar Firma</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" class="form-horizontal"
                                        action="{{ route('warehouse.visation_contract_manager.reject', $control->id) }}"
                                        enctype="multipart/form-data" id="rejectForm{{ $control->id }}">
                                        <div class="modal-body">
                                            @csrf
                                            <!-- input hidden contra ataques CSRF -->
                                            @method('POST')
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="forobservacion">Observación</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="forobservacion" name="observacion" maxlength="255"
                                                        autocomplete="off" form="rejectForm{{ $control->id }}" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                                            </button>

                                            <button form="rejectForm{{ $control->id }}" class="btn btn-danger"
                                                type="submit">
                                                <i class="fas fa-edit"></i> Rechazar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                    @endif
                </tr>
            @endforeach

        </tbody>

    </table>


@endsection
