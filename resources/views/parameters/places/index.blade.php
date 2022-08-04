<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($places as $place)
            <tr>
                <td class="text-center">{{ $place->id }}</td>
                <td>{{ $place->name }}</td>
                <td>{{ $place->description }}</td>
                <td>{{ $place->location->name }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" wire:click="edit({{ $place }})">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
        <caption>
            {{--
            Total de resultados: {{ $places->total() }}
            --}}
        </caption>
    </table>
</div>
{{--
{{ $places->links() }}
--}}