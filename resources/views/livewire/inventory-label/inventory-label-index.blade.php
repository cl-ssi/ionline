<div>
    @section('title', 'Etiquetas')

    <div class="row">
        <div class="col">
            <h3 class="my-1">Etiquetas de {{ $module }}</h3>
        </div>
        <div class="col text-right">
            <a
                class="btn btn-primary mb-3"
                href="{{ route('parameters.labels.create', $module) }}"
            >
                Crear
            </a>
        </div>
    </div>

    <div class="form-row my-2">
        <fieldset class="col">
            <label for="search" class="form-label">Buscador</label>
            <input
                type="text"
                id="search"
                class="form-control"
                placeholder="Ingresa el nombre de una etiqueta"
                wire:model.live.debounce.1500ms="search"
            >
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Color</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                >
                    <td class="text-center" colspan="3">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($labels as $label)
                    <tr wire:loading.remove>
                        <td>{{ $label->name ?? '' }}</td>
                        <td>
                            <span
                                class="badge badge-primary"
                                style="background-color: #{{ $label->color }};"
                            >
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('parameters.labels.edit', $label) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr wire:loading.remove>
                        <td class="text-center" colspan="3">
                            <em>No hay registros</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
