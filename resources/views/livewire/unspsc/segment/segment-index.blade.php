<div>

    <h3>Segmentos</h3>

    @include('unspsc.bread-crumbs', ['type' => 'segments.index'])

    <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text">Buscar</span>
        </div>
        <input type="text" class="form-control" wire:model.live.debounce.1500ms="search">
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Código</th>
                    <th>Nombre</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="4">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($segments as $segment)
                <tr wire:loading.remove>
                    <td class="text-center">
                        <a title="Ver familias"
                            href="{{ route('families.index', $segment) }}">
                            {{ $segment->code }}
                        </a>
                    </td>
                    <td>{{ $segment->name }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $segment->status_color }}">
                            {{ $segment->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-outline-secondary" title="Editar segmento"
                            href="{{ route('segments.edit', $segment) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="text-center" wire:loading.remove>
                    <td colspan="4"><em>No hay resultados</em></td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total resultados : {{ $segments->total() }}
            </caption>
        </table>

        {{ $segments->links() }}
    </div>
</div>
