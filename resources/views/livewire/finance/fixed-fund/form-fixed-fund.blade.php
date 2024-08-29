<div>
    <h3 class="mb-3">Crear nuevo fondo fijo</h3>

    @include('layouts.bt5.partials.flash_message')

    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <label for="for-concept">Concepto*</label>
            <!-- select with two options: movilización, fondo_fijo -->
            <select class="form-select" wire:model="fixedFund.concept">
                <option value="">Seleccione...</option>
                <option value="Transporte">Transporte</option>
                <option value="Gastos Menores">Gastos Menores</option>
            </select>
            @error('fixedFund.concept') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-5">
            <label for="for-user">Responsable*</label>
            @if($fixedFund->id) 
                @livewire('search-select-user', ['user' => $fixedFund->user])
            @else
                @livewire('search-select-user')
            @endif
            @error('fixedFund.user_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-2">
            <label for="for-period">Periodo*</label>
            <input type="month" class="form-control" wire:model.live="fixedFund.period">
            @error('fixedFund.period') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-2">
            <label for="for-total">Total*</label>
            <input type="number" class="form-control" wire:model="fixedFund.total">
            @error('fixedFund.total') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row mb-3 g-2">
        <div class="col-md-2">
            <label for="for-res_number">Nº Reso.</label>
            <input type="text" class="form-control" wire:model="fixedFund.res_number">
            @error('fixedFund.res_number') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3">
            <label for="for-delivery_date">Fecha de Entrega</label>
            <input type="date" class="form-control" wire:model="fixedFund.delivery_date">
            @error('fixedFund.delivery_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3">
            <label for="for-rendition_date">Fecha de Rendición</label>
            <input type="date" class="form-control" wire:model="fixedFund.rendition_date">
            @error('fixedFund.rendition_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

    </div>
    <div class="row g-2 mb-3">
        <div class="col-md-12">
            <label for="for-observations">Observación</label>
            <textarea class="form-control" wire:model="fixedFund.observations"></textarea>
            @error('fixedFund.observations') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <button class="btn btn-primary" wire:click="store">Guardar</button>
            <a href="{{ route('finance.fixed-fund.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </div>
</div>
