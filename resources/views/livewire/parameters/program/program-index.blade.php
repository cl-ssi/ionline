<div>
    <div class="row my-3">
        <div class="col">
            <h3>Programas</h3>
        </div>
        <div class="col text-right">
            <a
                href="{{ route('parameters.programs.create') }}"
                class="btn btn-primary"
            >
                <i class="fas fa-plus"></i> Crear Programa
            </a>
        </div>
    </div>

    <div class="input-group my-2">
        <div class="input-group-prepend">
            <span class="input-group-text">Buscar</span>
        </div>
        <input type="text" class="form-control" wire:model.live="search">
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Nombre</th>
                    <th>Establecimiento</th>
                    <th>Alias</th>
                    <th>Alias finanzas</th>
                    <th>Financiamiento</th>
                    <th>Folio</th>
                    <th>Subtitulo</th>
                    <th>Presup.</th>
                    <th>Periodo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search, delete">
                    <td class="text-center" colspan="5">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($programs as $program)
                <tr wire:loading.remove>
                    <td class="text-center">
                        <a
                            href="{{ route('parameters.programs.edit', $program) }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-edit"></i> {{ $program->id }}
                        </a>
                    </td>
                    <td>{{ $program->name }}</td>
                    <td>{{ $program->establishment?->alias }}</td>
                    <td>{{ $program->alias }}</td>
                    <td>{{ $program->alias_finance }}</td>
                    <td>{{ $program->financial_type }}</td>
                    <td>{{ $program->folio }}</td>
                    <td>{{ optional($program->subtitle)->name }}</td>
                    <td>{{ $program->budget ? number_format($program->budget, 0, ',', '.') : '' }}</td>
                    <td>{{ $program->period }}</td>
                    <td class="text-center">
                        <button
                            class="btn btn-sm btn-outline-danger"
                            onclick="confirm('¿Está seguro de eliminar este programa?') || event.stopImmediatePropagation()"
                            wire:click="delete({{ $program }})"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
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
                Total de Resultados: {{ $programs->total() }}
            </caption>
        </table>
    </div>

    {{ $programs->links() }}
</div>
