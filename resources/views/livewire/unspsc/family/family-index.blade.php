<div>
    @include('parameters.nav')

    <h5>Familias</h5>

    @include('unspsc.bread-crumbs', [
        'type' => 'families.index',
        'segment' => $segment
    ])

    <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text">Buscar</span>
        </div>
        <input type="text" class="form-control" wire:model="search">
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
                        <em>Cargando...</em>
                    </td>
                </tr>
                @forelse($families as $family)
                <tr wire:loading.remove>
                    <td class="text-center">
                        <a title="Ver clases"
                            href="{{ route('class.index', ['segment' => $segment, 'family' => $family]) }}">
                            {{ $family->code }}
                        </a>
                    </td>
                    <td>{{ $family->name }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $family->status_color }}">
                            {{ $family->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-outline-secondary"
                            title="Editar familia"
                            href="{{ route('families.edit', ['segment' => $segment, 'family' => $family]) }}">
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
                Total resultados : {{ $families->total() }}
            </caption>
        </table>

        {{ $families->links() }}
    </div>
</div>
