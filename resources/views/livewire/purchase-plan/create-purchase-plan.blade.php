<div>
    <h6 class="small"><b>1. Descripción</b></h6> <br>
    
    <form class="row g-3">
        <fieldset class="form-group col-4">
            <label for="for_user_responsible_id">Funcionario Responsable</label>
            @livewire('search-select-user', [
                'selected_id'   => 'user_responsible_id',
                'required'      => 'required',
                'emit_name'     => 'searchedUser'
            ])
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_telephone">Teléfono</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="telephone">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_email">Correo Electrónico</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="email">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_position">Cargo / Función</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="position">
        </fieldset>
    </form>
    
    <br>

    <form class="row g-3">
        <fieldset class="form-group col-6">
            <label for="for_user_allowance_id">Sub-dirección</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="subdirectorate" {{ $readonly }}>
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_user_allowance_id">Unidad Organizacional</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="organizationalUnit" {{ $readonly }} >
        </fieldset>
    </form>

    <br>

    <form class="row g-3">
        <fieldset class="form-group col-6">
            <label for="for_program">Programa</label>
            @livewire('search-select-program',
                ['emit_name' => 'searchedProgram']
            )
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_user_allowance_id">Asunto</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="subject">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_period">Periodo</label>
            <select class="form-select" wire:model.defer="period">
                <option value="0">Seleccione</option>
                <option value="2023" disabled>2023</option>
                <option value="2024">2024</option>
            </select>
        </fieldset>
    </form>
    
    <br>
    <hr>

    <h6 class="small"><b>2. Ítems a comprar</b></h6> <br>
    
    {{--
    @livewire('request-form.item.request-form-items', ['savedItems' => $requestForm->itemRequestForms ?? null, 'savedTypeOfCurrency' => $requestForm->type_of_currency ?? null])
    --}}

    @livewire('request-form.item.request-form-items', [
        'savedItems'            => null, 
        'savedTypeOfCurrency'   => null,
        'bootstrap'             => 'v5'
    ])
    <br>
    <hr>

    @if(count($errors) > 0 && $validateMessage == "description")
        <div class="alert alert-danger">
            <p>Corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <button wire:click="savePurchasePlan" class="btn btn-primary float-end" type="button" wire:loading.attr="disabled">
        <i class="fas fa-save"></i> Guardar
    </button>

    <br>
    <br>
</div>
