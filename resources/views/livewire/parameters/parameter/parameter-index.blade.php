<div>
    @section('title', 'Parámetros')

    <div class="row my-3">
        <div class="col">
            <h3>Parámetros</h3>
        </div>
        <div class="col text-right">
            <a
                href="{{ route('parameters.create') }}"
                class="btn btn-primary"
            >
                <i class="fas fa-plus"></i> Crear Parámetro
            </a>
        </div>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <select
                class="form-control"
                wire:model="module_selected"
                id="module-selected"
            >
                <option value="">Todos</option>
                @foreach($modules as $item)
                    <option
                        value="{{ $item->module }}"
                    >
                        {{ $item->module }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-8">
            <div class="input-group">
                <input type="text" class="form-control" wire:model="search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" wire:click="filter">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Establecimiento</th>
                    <th>Módulo</th>
                    <th>Parámetro</th>
                    <th>Clave</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none">
                    <td class="text-center" colspan="5">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($parameters as $parameter)
                <tr wire:loading.remove>
                    <td>
                        @if($parameter->establishment){{ $parameter->establishment->name }}@endif
                    </td>
                    <td>
                        {{ $parameter->module }}
                    </td>
                    <td>
                        {{ $parameter->parameter }}
                    </td>
                    <td>
                        {{ $parameter->value }}
                    </td>
                    <td class="text-center">
                        <a
                            class="btn btn-sm btn-outline-primary"
                            href="{{ route('parameters.edit', $parameter)}}"
                            title="Editar párametro"
                        >
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr wire:loading.remove>
                    <td class="text-center" colspan="5">
                        <em>No hay resultados</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total de Resultados: {{ $parameters->total() }}
            </caption>
        </table>
    </div>

    {{ $parameters->links() }}
</div>
