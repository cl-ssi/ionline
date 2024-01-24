<div class="mb-3">

    <div class="row">
        <div class="form-group col-12 col-md-3">
            <input type="text" class="form-control" 
                wire:model.defer="parameter.parameter"
                disabled>
        </div>

        <div class="form-group col-12 col-md-8">
            @if($type =='user')
                @livewire('search-select-user',['user' => $user])
            @else
                <input type="text" class="form-control" 
                    wire:model.defer="parameter.value">
            @endif
            <p class="form-text text-muted">{{ optional($parameter)->description }}</p>
        </div>

        <div class="form-group col-2 col-md-1">
            <button type="button" wire:click="save()" class="btn btn-primary">Guardar</button>
            <p class="form-text text-success">
            @if($save == 'spin') <i class="fas fa-cog fa-spin"></i>@endif
            {{ ($save) ? 'Ok' : '' }}
            </p>
        </div>

    </div>

</div>
