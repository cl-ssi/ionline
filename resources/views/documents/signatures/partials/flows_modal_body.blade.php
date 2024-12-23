<ul class="list-group">
    @if(isset($signatureFlowsModal))
        @foreach($signatureFlowsModal as $signatureFlow)

            @if($signatureFlow->status === 1)
                <li class="list-group-item list-group-item-success">
                    @if($signatureFlow->real_signer_id === null)
                        {{ $signatureFlow->type == 'firmante' ? 'Firmado ' : 'Visado ' }}
                        por {{ $signatureFlow->signerName }}
                        el {{ $signatureFlow->signature_date }}
                    @else
                        <b>Firmante Asignado: </b> {{ $signatureFlow->signerName }} <br>
                        <b>Firma Subrogada por: </b> {{ $signatureFlow->realSignerName }} <br>
                        <b>Fecha:</b> {{ $signatureFlow->signature_date }}
                    @endif
                </li>
            @elseif($signatureFlow->status === 0)
                <li class="list-group-item list-group-item-danger">
                    @if($signatureFlow->real_signer_id === null)
                        Rechazado por {{ $signatureFlow->signerName }}.<br>Motivo: {{ $signatureFlow->observation }}
                    @else
                        <b>Firmante Asignado: </b> {{ $signatureFlow->signerName }} <br>
                        <b>Rechazado por Subrogante: </b> {{ $signatureFlow->realSignerName }} <br>
                    @endif
                </li>
                
            @else
                <li class="list-group-item list-group-item-warning">
                    Pendiente 
                    {{ $signatureFlow->type == 'firmante' ? 'firma ' : 'visación ' }}
                    de {{ $signatureFlow->signerName }}
                </li>
            @endif
        @endforeach
    @endif
</ul>
