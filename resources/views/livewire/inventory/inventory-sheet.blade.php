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
            <button class="btn btn-primary" wire:loading.attr="disabled" wire:click="search" wire:target="search">Buscar</button>
    </div>


    @if(count($inventories) > 0)
    <div>
    <div class="text-center">
        <h2>PLANILLA MURAL DE INVENTARIO OFICINA CONTROL DE BIENES:</h2>
    </div>
        <table class="table">
            <tr>
                <th>DEPENDENCIA:</th>
                <td>{{ $place->name }}</td>
            </tr>
            <tr>
                <th>ZONA:</th>
                <td>{{ $place->architectural_design_code ??'' }}</td>
            </tr>
            <tr>
                <th>DEPARTAMENTO, SECCION Y OFICINA:</th>
                <td></td> 
            </tr>
            <tr>
                <th>NOMBRE ENCARGADO:</th>
                <td></td> 
            </tr>
            <tr>
                <th>NOMBRE FUNCIONARIOS:</th>
                <td></td>
            </tr>
        </table>

        <table class="table border">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>CÓDIGO INVENTARIO</th>
                    <th>DESCRIPCIÓN DE BIEN</th>
                    <th>ESTADO</th>
                    <th>CALIDAD</th>
                    <th>VALOR UNITARIO</th>
                    <th>FUNCIONARIO RESPONSABLE</th>
                    <th>OBSERVACIONES</th>
                    <th>FIRMAFUNCIONARIO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $inventory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $inventory->number }}</td>
                        <td>{{ $inventory->description }}</td>
                        <td>{{ $inventory->estado }}</td> 
                        <td></td> 
                        <td></td> 
                        <td>{{ $inventory->lastConfirmedMovement->responsibleUser->shortName }}</td>                     
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td>Total</td>
                    <td>$666</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endif



</div>
