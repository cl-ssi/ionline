<div>
    <div class="form-row mb-3">

        <div class="col-2">
            <input type="number"
                wire:model.debounce.defer="req_id"
                class="form-control"
                placeholder="N°">
        </div>
        <div class="col-3">
            <input type="text"
                wire:model.debounce.defer="subject"
                class="form-control"
                placeholder="Asunto">
        </div>
        <div class="col-3">
            <select wire:model.debounce.defer="label"
                class="form-control"
                placeholder="Etiqueta">
                <option value="">[Seleccione una etiqueta]</option>
                @foreach (auth()->user()->reqLabels->pluck('name') as $label)
                    <option value="{{ $label }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
        <select wire:model.debounce.defer="status"
                class="form-control">
                <option>Todos</option>
                <option>Pendientes</option>
                <option>Archivados</option>
            </select>
        </div>
        <div class="col-2 text-center">
            <button class="btn btn-secondary"
                wire:click="search"
                wire:loading.class="d-none">
                <i class="fas fa-search"
                    aria-hidden="true"></i>
            </button>
            <button class="btn btn-outline-secondary d-none"
                wire:loading.class.remove="d-none">
                <i class="fa fa-spinner fa-spin"
                    aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-2">
            <input type="text"
                wire:model.debounce.defer="parte"
                class="form-control"
                placeholder="Origen, N°Origen">
        </div>
        <div class="col-3">
        <input type="text"
                wire:model.debounce.defer="user_involved"
                class="form-control"
                placeholder="Usuario involucrado">
        </div>

        <div class="col-3">
            <select wire:model.debounce.defer="category_id"
                class="form-control">
                <option value="">[Seleccione una categoría]</option>
                @foreach(auth()->user()->organizationalUnit->categories->sortBy('name') as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-2">
            <select wire:model.debounce.defer="readedStatus"
                class="form-control">
                <option>Todos</option>
                <option>Sin leer</option>
            </select>
        </div>

        <div class="col-2 text-center">
            <span class="form-control-plaintext">
                Resultados: {{ $requirements->total() }}
            </span>
        </div>


    </div>


    @if ($requirements->isNotEmpty())
        @include('requirements.partials.list')
        {{ $requirements->links() }}
    @else
        <h4 class="text-danger text-center">No se han encontrado resultados.</h4>
        <hr>
    @endif

</div>
