<div>
    @include('inventory.nav', [
        'establishment' => auth()->user()->organizationalUnit->establishment->id
    ])
    <h3>Actualización Contable</h3>
    @include('layouts.bt5.partials.flash_message')
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <label for="for-folio_oc" class="form-label">Folio OC</label>
            <input type="text" class="form-control" wire:model="oc" placeholder="folio oc">
        </div>
        <div class="col-md-1">
            <label for="search" class="form-label">&nbsp;</label>
            <button class="btn btn-primary form-control" type="button" wire:click="search">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-1">
            <label for="update" class="form-label">&nbsp;</label>
            <button class="btn btn-secondary form-control" type="button" wire:click="update">
                Actualizar
            </button>
        </div>
    </div>

    <br><br>

    {{-- <div class="row g-2 mb-3">    
        <div class="col-md-4">
            <label for="total" class="form-label">Total: {{ number_format($total, 2) }}</label>
        </div>
    </div> --}}



    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nro. Inv.</th>
                    <th class="text-center">Std-Descripción</th>
                    <th >Vida Útil</th>
                    <th >Valor</th>
                    <th>Cuenta Contable</th>
                    <th>Fecha de Ingreso en Bodega</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                >

                    <td class="text-center" colspan="8">
                        @include('layouts.bt5.partials.spinner')
                    </td>
                </tr>
                @forelse($inventories as $key => $inventory)
                <tr wire:loading.remove>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        {{ $inventory->id }}
                    </td>
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
                    <td class="text-center text-nowrap" style="max-width: 150px;">
                        <input type="number" class="form-control" wire:model="usefulLife.{{ $inventory->id }}">
                    </td>
                    <td class="text-center text-nowrap" >
                        <input type="number" class="form-control" wire:model="poPrice.{{ $inventory->id }}" step="0.01" style="width: 120px;" >
                    </td>
                    <td>
                        <select class="form-select" wire:model="accountingCodes.{{ $inventory->id }}">
                            <option value="">Seleccione cuenta contable</option>
                            @foreach($allAccountingCodes as $accountingCode)
                                <option value="{{ $accountingCode->id }}" @if($accountingCode->id == $inventory->accounting_code_id) selected @endif>
                                    {{ $accountingCode->id }} - {{ $accountingCode->description }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        {{$inventory->control->date->format('d-m-Y')}}
                    </td>
                </tr>
                @empty
                <tr class="text-center" wire:loading.remove>
                    <td colspan="8">
                        <em>No hay registros</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>

</div>