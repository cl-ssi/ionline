<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

    <div class="row mb-3">
        <div class="col-6">
            <h3>Acta de Recepción en Sistema</h3>
        </div>             
            <div class="col">
                <a class="btn btn-sm btn-success" href="{{ route('finance.receptions.create') }}">
                    <i class="fas fa-plus"></i> Cargar Acta de Recepción</a>
            </div>
        </div>
    </div>

    
        <div class="row g-2 d-print-none mb-3">
            <fieldset class="form-group col-md-2">
                <label for="number">ID</label>
                <input
                    wire:model="filter_id"
                    id="filter_id"
                    class="form-control"
                    autocomplete="off"
                >
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="oc">OC</label>
                <input
                    wire:model="filter_purchase_order"
                    id="filter_purchase_order"
                    class="form-control"
                    autocomplete="off"
                >
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="number">Número</label>
                <input
                    wire:model="filter_number"
                    id="filter_number"
                    class="form-control"
                    autocomplete="off"
                >
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="responsibles">Responsables</label>
                <select
                    wire:model="filter_user_responsible_id"
                    id="responsibles"
                    class="form-control form-select"
                >
                    <option value="">Todos</option>
                </select>
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="number">Fecha Recepción</label>
                <input
                    wire:model="filter_date"
                    id="date"
                    class="form-control"
                    type="date"
                >
            </fieldset>

            <fieldset class="form-group col-md-1">
                <label for="">&nbsp;</label>
                <button
                    class="btn btn-primary form-control"
                    type="button"
                    wire:click="getReceptions"
                >
                    <i class="fas fa-filter"></i>
                </button>
            </fieldset>
        </div>
    

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>OC</th>
                    <th>Número</th>
                    <th>Responsable</th>
                    <th>Fecha Recepción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
                <tbody>
                    <tr
                        class="d-none"
                    >
                        <td class="text-center" colspan="7">
                            @include('layouts.bt5.partials.spinner')
                        </td>
                    </tr>
                        @forelse($receptions as $reception)
                        <tr>
                            <td class="text-center" nowrap>
                                {{ $reception->id }}
                            </td>
                            <td>
                                {{ $reception->purchase_order }}
                            </td>
                            <td>
                                {{ $reception->number }}
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No Hay Actas de Recepcion</td>
                        </tr>

                        @endforelse
                    
                </tbody>
        </table>
        {{ $receptions->links() }}
        
    </div>
</div>