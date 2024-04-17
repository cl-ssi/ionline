<div>    
    @include('inventory.nav', [
        'establishment' => auth()->user()->organizationalUnit->establishment->id
    ])
    <h3>Actualización Contable</h3>
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <label for="for-folio_oc" class="form-label">Folio OC</label>
            <input type="text" class="form-control" wire:model.defer="oc" placeholder="folio oc">
        </div>
        <div class="col-md-1">
            <label for="search" class="form-label">&nbsp;</label>
            <button class="btn btn-primary form-control" type="button" wire:click="search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nro. Inv.</th>
                    <th class="text-center">Std-Descripción</th>
                    <th>Vida Útil</th>
                    <th>Valor</th>
                    <th>Cuenta Contable</th>
                    <th>Id Bodega</th>
                    <th>Fecha Entrega</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                >
                    <td class="text-center" colspan="7">
                        @include('layouts.bt5.partials.spinner')
                    </td>
                </tr>
                @forelse($inventories as $inventory)
                <tr wire:loading.remove>
                    <td class="text-center" nowrap>
                        <small>
                            <a href="{{ route('inventories.show', ['establishment' => $establishment, 'number' => $inventory->number]) }}">
                                {{ $inventory->number }}
                            </a>
                        </small>
                    </td>
                    <td>
                        @if($inventory->unspscProduct)
                            <b>Std:</b> {{ $inventory->unspscProduct->name }}
                        @endif
                        <br>
                        <small>
                            @if($inventory->product)
                                <b>Bodega:</b> {{ $inventory->product->name }}
                            @else
                                <b>Desc:</b> {{ $inventory->description }}
                            @endif
                        </small>
                    </td>
                    <td>
                        {{ $inventory->useful_life }}
                    </td>
                    <td>
                        {{ $inventory->po_price }}
                    </td>
                    <td>
                        <option value="">Seleccione cuenta contable</option>
                    @foreach($accountingCodes as $accountingCode)
                        <option value="{{ $accountingCode->id }}">
                        {{ $accountingCode->id }} - {{ $accountingCode->description }}
                        </option>
                    @endforeach

                    </td>


                </tr>
                @empty
                <tr class="text-center" wire:loading.remove>
                    <td colspan="7">
                        <em>No hay registros</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>


</div>
