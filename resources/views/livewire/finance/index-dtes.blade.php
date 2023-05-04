<div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('finance.dtes.index') }}">Ver dtes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('finance.dtes.upload') }}">Cargar archivo</a>
        </li>
    </ul>

    
    <h3 class="mb-3">Listado de dtes cargadas en sistema</h3>

    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" class="form-control" wire:model.defer="filter.folio" placeholder="folio">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" wire:model.defer="filter.folio_oc" placeholder="oc">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary" type="button" wire:click="render()"> <i class="fas fa-search"></i> Buscar</button>
        </div>
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Tipo documento</th>
                <th>Folio</th>
                <th>Emisor</th>
                <th>Folio OC</th>
                <th>Detalle</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
            <tr>
                <td>{{ $dte->tipo_documento }}</td>
                <td>{{ $dte->folio }}</td>
                <td>{{ $dte->emisor }}</td>
                <td>{{ $dte->folio_oc }}</td>
                <td>
                    <button class="btn btn-outline-secondary" type="button" data-toggle="collapse" data-target="#collapse{{$dte->id}}" aria-expanded="false" aria-controls="collapse{{$dte->id}}">
                        Ver detalle
                    </button>
                    <div class="collapse width" id="collapse{{$dte->id}}">
                        <pre>
                            {{ print_r($dte->toArray()) }}
                        </pre>
                    </div>
                </td>
                <td>
                    <a href="{{ $dte->uri }}" target="_blank" class="link"> <i class="fas fa-paperclip"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
 
    {{ $dtes->links() }}
</div>
