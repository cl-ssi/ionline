<div>
    <div class="row">
        <div class="col-8">
            <h3 class="mb-3">Telefonos Fijos</h3>
        </div>
        <div class="col-4 text-end">
            <a class="btn btn-success "
                href="{{ route('resources.telephone.create') }}">
                <i class="bi bi-plus"></i> Agregar nuevo
            </a>
        </div>
    </div>

    <div class="row g-2 mb-3">
        <div class="form-group col-4">
            <label for="estab">Establecimiento</label>
            <select wire:model="establishment_id" class="form-select">
                <option value="todos">Todos los establecimientos</option>
                <option value="">Sin Establecimiento</option>
                @foreach ($establishments as $est)
                <option value="{{ $est->id }}">{{ $est->official_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-2">
            <label for="form-anexo">Anexo</label>
            <input type="text" class="form-control" wire:model="filter">
        </div>

        <div class="form-group col-1">
            <label for="form-anexo">Search</label>
            <button class="btn btn-outline-secondary" wire:click="search"><i class="bi bi-search"></i></button>
        </div>


    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm"
            id="TableFilter">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Estb.</th>
                    <th scope="col">Número</th>
                    <th scope="col">Minsal</th>
                    <th scope="col">Asociado a</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($telephones as $key => $telephone)
                    <tr>
                        <td>{{ ++$key }} </td>
                        <td>{{ $telephone->place?->establishment->alias }} </td>
                        <td>{{ $telephone->number }} </td>
                        <td>{{ $telephone->minsal }}</td>
                        <td>
                            @if ($telephone->users->count() > 0)
                                @foreach ($telephone->users as $user)
                                    {{ $user->shortName }} <br>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            {{ $telephone->place ? $telephone->place->location->name : '' }}
                        </td>
                        <td>
                            <small>{{ $telephone->place ? $telephone->place->name : '' }}</small>
                        </td>
                        <td>
                            @if($telephone->trashed())
                                <button class="btn btn-secondary btn-sm" wire:click="restore({{$telephone->id}})" title="Restaurar">
                                    <i class="bi bi-plus-circle-dotted"></i>
                                </button>
                            @else
                                <a href="{{ route('resources.telephone.edit', $telephone->id) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <span class="bi bi-pencil-square"
                                        aria-hidden="true"></span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $telephones->links() }}

</div>
