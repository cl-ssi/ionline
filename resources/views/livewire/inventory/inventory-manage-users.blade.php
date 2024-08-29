<div>
    @section('title', 'Usuarios de Inventario')

    <div class="row my-3">
        <div class="col">
            <h5>Establecimiento: {{ $establishment->name }}</h5>
            <p>Usuarios que pueden ver el inventario del establecimiento</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <fieldset class="form-group col-md-12">
                            <label for="search">Buscar usuario</label>
                            @livewire('users.search-user', [
                                'smallInput' => true,
                                'placeholder' => 'Ingrese un nombre',
                                'eventName' => 'myUserId',
                                'tagId' => 'user-id',
                                'idsExceptUsers' => $establishment->usersInventories->pluck('id'),
                                'bt' => 4,
                            ])
                            <input
                                class="@error('user_id') is-invalid @enderror"
                                type="hidden"
                            >
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>

                        <fieldset class="form-group col-md-6">
                            <label for="role-id">Rol</label>
                            <select
                                class="form-control form-control-sm @error('role_id') is-invalid @enderror"
                                wire:model.live.debounce.1500ms="role_id"
                                id="role-id"
                            >
                                <option value="">Selecciona un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ __($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>

                        <fieldset class="form-group col-md-12">
                            <button
                                class="btn btn-primary"
                                wire:click="addUser"
                                wire:target="addUser"
                                wire:loading.attr="disabled"
                            >
                                Agregar usuario
                            </button>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text">Buscar</span>
                </div>
                <input
                    type="text"
                    class="form-control"
                    wire:model.live.debounce.600ms="search_user"
                    placeholder="Buscar en usuarios"
                >
                <div class="input-group-append">
                    <button
                        class="btn btn-sm btn-outline-secondary"
                        type="button"
                        title="Limpiar búsqueda"
                        wire:click="clearSearchUser"
                    >
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre y Apellido</th>
                            <th>Rol</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search_user">
                            <td class="text-center" colspan="3">
                                @include('layouts.bt4.partials.spinner')
                            </td>
                        </tr>
                        @forelse($users as $itemUser)
                            <tr wire:loading.remove wire:target="search_user">
                                <td>
                                    <small>{{ $itemUser->user->short_name }}</small>
                                </td>
                                <td>
                                    <small>{{ __($itemUser->role->name) }}</small>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:click="deleteUser({{ $itemUser->user }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr wire:loading.remove wire:target="search_user">
                                <td class="text-center" colspan="3">
                                    <em>No hay resultados</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <caption>
                        Total de resultados: {{ $users->total() }}
                    </caption>
                </table>
                <small>
                    {{ $users->links() }}
                </small>
            </div>

        </div>
    </div>


</div>
