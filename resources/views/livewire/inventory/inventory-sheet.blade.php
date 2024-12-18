<div>
    @section('title', 'Bandeja Pendiente')

    @include('inventory.nav', [
        'establishment' => auth()->user()->organizationalUnit->establishment
    ])


    <fieldset class="col-md-6">
            <label for="place-id" class="form-label">
                Ubicación a Generar la Planilla Mural
            </label>

            @livewire('places.find-place', [
                'smallInput' => true,
                'tagId' => 'place-id',
                'placeholder' => 'Ingrese una ubicación o cod. arq.',
                'establishment' => auth()->user()->organizationalUnit->establishment,
            ])
            <input
                class="form-control @error('place_id') is-invalid @enderror"
                type="hidden"
            >

            @error('place_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </fieldset>

    <br>
    <div class="col-md-1">
            <label class="form-label">
                &nbsp; 
            </label>
        <button class="btn btn-primary" wire:loading.attr="disabled" wire:click="search" wire:target="search" @if(!$place_id) disabled @endif>Buscar</button>
    </div>


    @if(count($inventories) > 0)

    <div class="text-center">
        <a href="{{ route('parameters.places.board', ['establishment' => auth()->user()->organizationalUnit->establishment, 'place' => $place]) }}" class="btn btn-sm btn-outline-secondary mt-3" target="_blank">
            <i class="bi bi-printer"></i> Generar Planilla Mural
        </a>
    </div>


    <div>
    <br>
    <div class="text-end">
        <h6>Fecha de Emisión: {{ now()->format('d-m-Y H:i:s') }}</h6>
    </div>
    <br>
    <div class="text-center">
        <h2>PLANILLA MURAL DE INVENTARIO OFICINA CONTROL DE BIENES:</h2>
    </div>
    <table class="table">
    <tr class="row">
        <th class="col-md-3">DEPENDENCIA:</th>
        <td class="col-md-3">{{ $place->name }}</td>
        <th class="col-md-3">ZONA:</th>
        <td class="col-md-3">{{ $place->architectural_design_code ??'' }}</td>
    </tr>
    <tr class="row">
        <th class="col-md-3">RESPONSABLE(S):</th>
        <td class="col-md-3" colspan="3">
            <ul>
                @foreach($inventories->unique('lastConfirmedMovement.responsibleUser.id') as $inventory)
                    <li>{{ $inventory->lastConfirmedMovement->responsibleUser->shortName }}</li>
                @endforeach
            </ul>
        </td>
    </tr>
    <tr class="row">
        <th class="col-md-3">USUARIO(S):</th>
        <td class="col-md-3" colspan="3">
            <ul>
                @foreach($uniqueUsers as $user)
                    @if($user && isset($user->tinyName))
                        <li>{{ $user->tinyName }}</li>
                    @endif
                @endforeach
            </ul>
        </td>
    </tr>
</table>


        <table class="table border">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>CÓDIGO INVENTARIO</th>
                    <th>DESCRIPCIÓN DE BIEN</th>
                    <th>ESTADO</th>
                    <th>CLASIFICACIÓN</th>
                    <th>VALOR UNITARIO</th>
                    <th>OBSERVACIONES</th>
                    <th>FUNCIONARIO RESPONSABLE</th>
                    <th>FECHA DE RECEPCIÓN</th>
                    <th>RECEPCIÓN DIGITAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $inventory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $inventory->number }}</td>
                        <td>{{ $inventory->description }}</td>
                        <td>{{ $inventory->estado }}</td> 
                        <td>{{ $inventory->classification?->name }}</td> 
                        <td>${{ money($inventory->po_price) }}</td>
                        <td>{{ $inventory->observations }}</td>
                        <td>{{ $inventory->lastConfirmedMovement->responsibleUser->shortName }}</td>
                        <td>{{ $inventory->lastConfirmedMovement->reception_date->format('d-m-Y')}}</td> 
                        <td>@include('sign.custom-clave-unica',['user'=>$inventory->lastConfirmedMovement->responsibleUser, 'date' => $inventory->lastConfirmedMovement->reception_date])</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td>Total</td>
                    <td>${{ money($inventories->sum('po_price')) }}</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endif



</div>
