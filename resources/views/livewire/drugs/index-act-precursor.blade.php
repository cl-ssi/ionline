<div>
    @section('title', 'Actas de Precursores')

    @include('drugs.nav')

    <div class="row">
        <div class="col">
            <h3 class="mb-3">Actas de Precursores</h3>
        </div>
        <div class="col text-right">
            <a href="{{ route('drugs.precursors.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear Acta Precursores
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered small">
            <thead>
                <tr>
                    <th class="text-center">N. Acta</th>
                    <th>Fecha Acta</th>
                    <th>Cantidad Precursores</th>
                    <th>Persona Recibe</th>
                    <th>Persona Entrega</th>
                    <th class="text-center">Acta</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($acts as $act)
                <tr>
                    <td class="text-center">{{ $act->id }}</td>
                    <td>{{ $act->date->format('Y-m-d') }}</td>
                    <td>{{ $act->precursors->count() }}</td>
                    <td>{{ $act->full_name_receiving }}</td>
                    <td>{{ optional($act->delivery)->short_name }}</td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-outline-success" href="{{ route('drugs.precursors.pdf', $act) }}" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        @can('Drugs: edit date receptions')
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('drugs.precursors.edit', $act) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No hay registros
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>


    </div>
</div>
