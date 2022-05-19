<div>
    <h3 class="my-2">Programas</h3>

    <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text">Buscar</span>
        </div>
        <input type="text" class="form-control" wire:model="search">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Nombre</th>
                    <th class="text-center">Inicio</th>
                    <th class="text-center">Fin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="5">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($programs as $program)
                <tr wire:loading.remove>
                    <td class="text-center">
                        <a href="#" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit"></i> {{ $program->id }}
                        </a>
                    </td>
                    <td>{{ $program->name }}</td>
                    <td class="text-center">{{ $program->start_format }}</td>
                    <td class="text-center">{{ $program->end_format }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-danger">
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
