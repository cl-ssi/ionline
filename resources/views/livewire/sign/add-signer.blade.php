<div>
    <div class="form-row">
        <div class="form-group col-12">
            <label for="establishment-id">Establecimiento</label>
            <select
                class="custom-select"
                id="establishment-id"
                wire:model="establishment_id"
            >
                <option value="">Seleccione establecimiento</option>
                @foreach($establishments->sortBy('name') as $establishment)
                    <option value="{{ $establishment->id }}"> {{ $establishment->official_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-12">
            <label for="">Buscar Unidad Organizacional</label>
            <input
                type="text"
                class="form-control"
                placeholder="Ingrese una unidad"
                wire:model="search_organizational_unit"
            >
        </div>

        <div class="form-group col-12">
            <label for="ou">Unidad Organizacional</label>
            <select
                class="custom-select"
                wire:model="organizational_unit_id"
                style="font-family:monospace;"
                id="ou"
            >
                <option value="">Seleccione unidad</option>
                @foreach($ous as $id => $ou)
                    <option value="{{ $id }}">{{ $ou }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-12">
            <label for="user-id">Usuarios</label>
            <div class="input-group mb-3">
                <select
                    class="custom-select"
                    wire:model="user_id"
                    id="user-id"
                >
                    <option>Seleccione usuario</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            @if($organizationalUnit->currentManager && $organizationalUnit->currentManager->user)
                                @if($organizationalUnit->currentManager->user->id == $user->id)
                                👑
                                @endif
                            @endif
                            {{ $user->short_name }}
                        </option>
                    @endforeach
                </select>

                <div class="input-group-append">
                    <button
                        class="btn btn-md btn-primary"
                        wire:click="add"
                        @if($user_id == '') disabled @endif
                    >
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
