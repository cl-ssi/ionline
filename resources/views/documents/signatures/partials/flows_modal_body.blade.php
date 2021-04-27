<ul class="list-group">
    @if(isset($signatureFlowsModal))
        @foreach($signatureFlowsModal as $signatureFlow)

            @if($signatureFlow->status === 1)
                <li class="list-group-item list-group-item-success">@if($signatureFlow->type == 'firmante')
                        Firmado por @else Visado por @endif {{$signatureFlow->signerName}}
                    el {{$signatureFlow->signature_date}} </li>
            @elseif($signatureFlow->status === 0)
                <li class="list-group-item list-group-item-danger">
                        Rechazado por {{$signatureFlow->signerName}}</li>
            @else
                <li class="list-group-item list-group-item-warning">@if($signatureFlow->type == 'firmante')
                        Pendiente firma por @else Pendiente visación
                        por @endif{{$signatureFlow->signerName}}</li>
            @endif
        @endforeach
    @endif
</ul>
