<div>
    <div class="row my-3">
        <div class="col">
            <h5>Usuarios: {{ $store->name }}</h5>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <fieldset class="form-group col-md-12">
                            <label for="search">Buscar usuario</label>
                            <div class="input-group input-group-sm has-validation">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" wire:loading.remove wire:target="search">
                                        @if($user_id == null)
                                            <i class="fas fa-times text-danger"></i>
                                        @else
                                            <i class="fas fa-check text-success"></i>
                                        @endif
                                    </span>
                                    <span class="input-group-text" wire:loading wire:target="search">
                                        <span
                                            class="spinner-border spinner-border-sm"
                                            role="status"
                                            aria-hidden="true"
                                        >
                                        </span>
                                        <span class="sr-only">...</span>
                                    </span>
                                </div>

                                <input
                                    type="text"
                                    id="search"
                                    class="form-control form-control-sm @error('user_id') is-invalid @enderror"
                                    wire:model.live.debounce.500ms="search"
                                    placeholder="{{ $selectedName }}"
                                    value="{{ $selectedName }}"
                                    @if($user_id) disabled @endif
                                >
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-secondary"
                                        type="button" wire:click="clearSearch">
                                        <i class="fas fa-eraser"></i> Limpiar
                                    </button>
                                </div>

                                @error('user_id')
                                    <span class="invalid-feedback @if($users->count() > 0) d-none @endif" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <ul class="list-group col-12" style="z-index: 3; position: absolute;">
                                @if($search)
                                    @forelse($users as $user)
                                        <a wire:click.prevent="addSearchedUser({{ $user }})"
                                            class="list-group-item list-group-item-action py-1">
                                            <small>{{ $user->full_name }}</small>
                                        </a>
                                    @empty
                                        <div class="list-group-item list-group-item-danger py-1">
                                            <small>No hay resultados</small>
                                        </div>
                                    @endforelse
                                @endif
                            </ul>
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
                            <button class="btn btn-primary" wire:click="addUser">
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
                    placeholder="Buscar en usuarios de la bodega"
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
                        @forelse($addedUsers as $itemUser)
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
                        Total de resultados: {{ $addedUsers->total() }}
                    </caption>
                </table>
                <small>
                    {{ $addedUsers->links() }}
                </small>
            </div>
        </div>
    </div>
</div>
