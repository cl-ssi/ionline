<div>
    <!-- MENU -->
    @include('finance.receptions.partials.nav')

    <h3 class="mb-3">Dtes de Cenabast</h3>
    <p class="text-muted">Asigne un administrador de contrato y clasifique los documentos tributarios de Cenabast según el establecimiento correspondiente al administrador seleccionado.</p>


    <div class="row g-2">
        <!-- Filtro por establecimiento -->
        <div class="col-md-3">
            <div class="form-group">
                <label for="establishment">Establecimiento</label>
                <select class="form-select" id="establishment" wire:model="establishment_id">
                    <option value="">Todos</option>
                    <option value="Sin">Sin establecimiento</option>
                    @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}">{{ $establishment->alias }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- filtro por folio_oc -->
        <div class="col-md-3">
            <div class="form-group">
                <label for="folio_oc">Folio OC</label>
                <input type="text" class="form-control" id="folio_oc" wire:model="folio_oc">
            </div>
        </div>
        <!-- filtro por folio -->
        <div class="col-md-3">
            <div class="form-group">
                <label for="folio">Folio</label>
                <input type="text" class="form-control" id="folio" wire:model="folio">
            </div>
        </div>
        <div class="col-md-1">
            <br>
            <button class="btn btn-secondary" wire:click="search">
                <i class="bi bi-search"></i>
            </button>
            <!-- spinner on wire loading -->
            <div wire:loading wire:target="search" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <!-- filtro sin receptiones -->
        <div class="col-md-2">
            <div class="form-group">
                <input type="checkbox" class="form-check-input" style="width: 34px; height: 34px;" id="folio" wire:model="without_reception">
                <label class="form-label pt-2" for="folio">Sin recepción</label>
            </div>
        </div>
        <!-- filtro sin administrador de contrato -->
        <div class="col-md-3">
            <div class="form-group">
                <input type="checkbox" class="form-check-input" style="width: 34px; height: 34px;" id="folio" wire:model="without_contract_manager">
                <label class="form-label pt-2" for="folio" >Sin administrador de contrato</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <label class="mt-2" for="contract-manager">Defina quien es el administrador de contrato</label>
            @livewire('search-select-user')
        </div>
    </div>

    <table class="table table-sm table-bordered mt-3" wire:loading.class="text-mutted">
        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>Recepciones</th>
                <th width="55px">Estb.</th>
                <th>Admin. de contrato</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dtes as $dte)
            <tr>
                <td>
                    {{ $dte->id }}
                </td>
                <td>
                    {{ $dte->tipo_documento }} {{ $dte->folio }}
                </td>
                <td>
                    {{ $dte->folio_oc }}
                </td>
                <td>
                    @if($dte->purchaseOrder)
                        @if($dte->purchaseOrder->receptions->count() > 0)
                            @foreach($dte->purchaseOrder->receptions as $reception)
                                <li>
                                    {{ $reception->id }} - {{ $reception->created_at->format('Y-m-d') }}
                                </li>
                            @endforeach
                        @endif
                    @endif
                </td>
                <td>
                    {{ $dte->establishment?->alias }}
                </td>
                <td>
                    @if($dte->contract_manager_id)
                        {{ $dte->contractManager->shortName }}
                    @endif
                    <br>
                    <button class="btn btn-sm btn-primary" wire:click="setContractManager({{$dte}})" @disabled(is_null($this->contract_manager_id))>
                        Asignar admin de contrato y establecimiento
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $dtes->links() }}
</div>
