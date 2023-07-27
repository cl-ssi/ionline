<div>
    <h3>Estimado/a 
        {{-- 
        @if($dte->requestForm)
            {{ $dte->requestForm->contractManager->shortName }}
        @endif 
        --}}
    </h3>

    <p>
        El siguiente DTE (documento tributario electrónico) fué recepcionado en portal DIPRES Acepta.<br>
        {{-- 
        @if($dte->requestForm)
            Está asociado al formulario de requerimiento Fólio Nº: <strong>{{ $dte->requestForm->folio }}</strong> de 
            <strong>{{ $dte->requestForm->contractOrganizationalUnit->name }}</strong>. <br>
        @endif 
        --}}
        Solicito favor señalar aceptación o reclamo del documento:
    </p>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>TIPO DOCUMENTO</th>
                <th>FOLIO</th>
                <th>RUT</th>
                <th>RAZON SOCIAL EMISOR</th>
                <th>PUBLICACION</th>
                <th>EMISION</th>
                <th>MONTO TOTAL</th>
                <th>FECHA MÁXIMO PARA RECLAMAR</th>
                <th>FOLIO OC</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @switch($dte->confirmation_status)
                        @case('0')
                            <i class="fas fa-fw fa-hand-middle-finger text-danger"></i>
                            @break
                        @case('1')
                            <i class="fas fa-fw fa-thumbs-up text-success"></i>
                            @break
                        @case(null)
                            <i class="fas fa-fw fa-hourglass-start"></i>
                            @break

                    @endswitch
                </td>
                <td>{{ $dte->tipo_documento }}</td>
                <td>
                    <a 
                        href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}" 
                        target="_blank" 
                        class="btn btn-sm mb-1 btn-outline-secondary"
                    > 
                        <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                    </a>
                </td>
                <td>{{ $dte->emisor }}</td>
                <td>{{ $dte->razon_social_emisor }}</td>
                <td>{{ $dte->publicacion }}</td>
                <td>{{ $dte->emision }}</td>
                <td class="text-right">$ {{ money($dte->monto_total) }}</td>
                <td>{{ optional(optional($dte->publicacion)->add('+3 days'))->format('Y-m-d') }}</td>
                <td>{{ $dte->folio_oc }}</td>
            </tr>
        </tbody>
    </table>


    @if(is_null($dte->confirmation_status))
    <div class="form-group">
        <label for="confirmation_observation">Observación (obligatoria al reclamar)</label>
        <input type="text" class="form-control" wire:model="confirmation_observation">
    </div>

    <div class="btn-group mb-3" role="group" aria-label="Confirmation">
        <button type="button" class="btn btn-success" wire:click="saveConfirmation(true)">
            <i class="fas fa-fw fa-thumbs-up"></i> Aceptar
        </button>
        <button type="button" class="btn btn-danger" wire:click="saveConfirmation(false)">
            <i class="fas fa-fw fa-thumbs-down"></i> Reclamar
        </button>
    </div>

    <br>

    <p>
        En el evento de aceptar el documento tributario electrónico se solicita remitir Acta de Recepcion conforme al Depto. de Abastecimiento y Logística.
    </p>
    @endif

    <b>
        Atentamente Abastecimiento.
    </b>
</div>