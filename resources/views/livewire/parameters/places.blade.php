<div>
    @include('layouts.bt4.partials.flash_message')

    @switch($view)
        @case('index')
            <div class="row">
                <div class="col-8">
                    <h4 class="mb-3">
                        @if($establishment)
                            {{ $establishment->name }}:
                        @endif
                        Lugares
                    </h4>
                </div>
                @can('Inventory: manager')
                    <div class="col  text-end">
                        <button
                            class="btn btn-primary"
                            wire:click="create"
                        >
                            <i class="fas fa-plus"></i>
                            Crear nuevo
                        </button>
                    </div>
                @endcan
            </div>
            @include('parameters.places.index')
            @break

        @case('create')
            <h3>Crear nuevo lugar</h3>
            @include('parameters.places.form')
            <button
                class="btn btn-primary"
                type="button"
                wire:target="store"
                wire:loading.attr="disabled"
                wire:click="store"
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="store"
                    aria-hidden="true"
                >
                </span>

                <span wire:loading.remove wire:target="store">
                    <i class="fas fa-save"></i>
                </span>

                Crear
            </button>
            <button
                type="button"
                class="btn btn-outline-secondary"
                wire:click="index"
            >
                Cancelar
            </button>
            @break

        @case('edit')
            <h3>Editar lugar</h3>
            @include('parameters.places.form')
            <button
                class="btn btn-primary"
                type="button"
                wire:target="update"
                wire:loading.attr="disabled"
                wire:click="update({{ $place }})"

            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="update"
                    aria-hidden="true"
                >
                </span>

                <span wire:loading.remove wire:target="update">
                    <i class="fas fa-save"></i>
                </span>

                Guardar
            </button>
            <button
                type="button"
                class="btn btn-outline-secondary"
                wire:click="index"
            >
                Cancelar
            </button>
            @break

    @endswitch
</div>
