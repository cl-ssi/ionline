@extends('layouts.app')
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
                @if(!$tray)
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
                                        ? route('request_forms.show_file', $control->requestForm->requestFormFiles->first() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$control->requestForm, 1]) }}"
                                    target="_blank" title="Certificado">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif

                            @if ($control->requestForm->old_signatures_file_id)
                                <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anterior firmado"
                                    href="{{ $control->requestForm->old_signatures_file_id == 11
                                        ? route('request_forms.show_file', $control->requestForm->requestFormFiles->first() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$control->requestForm, 0]) }}"
                                    target="_blank" title="Certificado">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif

                            @if ($control->requestForm->signedOldRequestForms->isNotEmpty())
                                <a class="btn btn-secondary btn-sm"
                                    title="Ver Formulario de Requerimiento Anteriores firmados"
                                    href="{{ $control->requestForm->old_signatures_file_id == 11
                                        ? route('request_forms.show_file', $control->requestForm->requestFormFiles->first() ?? 0)
                                        : route('request_forms.signedRequestFormPDF', [$control->requestForm, 0]) }}"
                                    target="_blank" data-toggle="modal"
                                    data-target="#history-fr-{{ $control->requestForm->id }}">
                                    <i class="fas fa-file-contract"></i>
                                </a>
                            @endif
                        @endif
                    </td>
                    @if(!$tray)
                    <td>
                        <form action="{{ route('warehouse.visation_contract_manager.accept', $control) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm" title="Aceptar">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <!-- Icono de Rechazar -->
                        <a href="#" class="btn btn-danger btn-sm" title="Rechazar">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                    @endif
                </tr>
            @endforeach

        </tbody>

    </table>


@endsection
