<div>

    <div class="row">
        <div class="col">
            <div class="input-group mb-3">
            <input type="text" class="form-control" wire:model.defer="filter.folio">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" wire:click="render()">Buscar</button>
            </div>
        </div>
        </div>
        <div class="col-md-2">
            <a href="{{ route('finance.dtes.upload') }}" class="btn btn-primary">Cargar archivo</a>
        </div>
    </div>




    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Tipo documento</th>
                <th>Folio</th>
                <th>Emisor</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
            <tr>
                <td>{{ $dte->tipo_documento }}</td>
                <td>{{ $dte->folio }}</td>
                <td>{{ $dte->emisor }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
 
    {{ $dtes->links() }}
</div>
