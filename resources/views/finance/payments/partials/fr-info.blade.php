@if ($dte->requestForm)
    <a href="{{ route('request_forms.show', $dte->requestForm->id) }}" target="_blank">
        {{ $dte->requestForm->folio }}
    </a>
    <br>
    @if ($dte->requestForm->signatures_file_id)
        <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado"
            href="{{ $dte->requestForm->signatures_file_id == 11
                ? route('request_forms.show_file', $dte->requestForm->requestFormFiles->last() ?? 0)
                : route('request_forms.signedRequestFormPDF', [$dte->requestForm, 1]) }}"
            target="_blank" title="Certificado">
            <i class="fas fa-fw fa-file-contract"></i>
        </a>
    @endif

    @if ($dte->requestForm->old_signatures_file_id)
        <a class="btn btn-secondary btn-sm"
            title="Ver Formulario de Requerimiento Anterior firmado"
            href="{{ $dte->requestForm->old_signatures_file_id == 11
                ? route('request_forms.show_file', $dte->requestForm->requestFormFiles->last() ?? 0)
                : route('request_forms.signedRequestFormPDF', [$dte->requestForm, 0]) }}"
            target="_blank" title="Certificado">
            <i class="fas fa-fw fa-file-contract"></i>
        </a>
    @endif

    @if ($dte->requestForm->signedOldRequestForms->isNotEmpty())
        <a class="btn btn-secondary btn-sm"
            title="Ver Formulario de Requerimiento Anteriores firmados"
            href="{{ $dte->requestForm->old_signatures_file_id == 11
                ? route('request_forms.show_file', $dte->requestForm->requestFormFiles->last() ?? 0)
                : route('request_forms.signedRequestFormPDF', [$dte->requestForm, 0]) }}"
            target="_blank" data-toggle="modal"
            data-target="#history-fr-{{ $dte->requestForm->id }}">
            <i class="fas fa-fw fa-file-contract"></i>
        </a>
    @endif

@endif