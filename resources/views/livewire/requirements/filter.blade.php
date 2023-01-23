<div>
    
    <div class="input-group mb-3">
        <input type="number" wire:model.debounce.600ms="req_id" class="form-control" placeholder="N°">
        <input type="text" wire:model.debounce.600ms="subject" class="form-control" placeholder="Asunto">
        <select wire:model.debounce.600ms="label" class="form-control">
            <option></option>
            @foreach(auth()->user()->reqLabels->pluck('name') as $label)
            <option>{{ $label }}</option>
            @endforeach
        </select>
        <input type="text" wire:model.debounce.600ms="user_involved" class="form-control" placeholder="Usuario involucrado">
        <input type="text" wire:model.debounce.600ms="parte" class="form-control" placeholder="Origen, N°Origen">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" wire:click="search">
                <i class="fas fa-search" aria-hidden="true"></i></button>
            </div>
    </div>

	@if($requirements)
    	
		@if($requirements->isNotEmpty())
    	
			<h4>Resultado de la busqueda</h4>
			@include('requirements.partials.list')

		@else

			<h4 class="text-danger text-center">Que penita, no se han encontrado resultados.</h4>
			<hr>

		@endif

    @endif
</div>