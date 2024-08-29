<div>
    <div class="row my-2">
        <div class="col">
            <h5>Categorías: {{ $store->name }}</h5>
        </div>
        <div class="col text-right">
            <a
                href="{{ route('warehouse.categories.create', ['store' => $store, 'nav' => $nav]) }}"
                class="btn btn-sm btn-primary"
            >
                <i class="fa fa-plus"></i> Crear Categoría
            </a>
        </div>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Buscar</span>
        </div>
        <input
            class="form-control"
            type="text"
            wire:model.live.debounce.1500ms="search"
            placeholder="Buscar por nombre"
        >
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="3">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($categories as $category)
                <tr wire:loading.remove wire:target="search">
                    <td class="text-center">
                        <a href="{{ route('warehouse.categories.edit', ['store' => $store, 'category' => $category, 'nav' => $nav]) }}"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                            {{ $category->id }}
                        </a>
                    </td>
                    <td>{{ $category->name }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-danger" wire:click="deleteCategory({{ $category }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="3">
                            <em>No hay resultados</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
