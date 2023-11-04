<div>
    @foreach($users as $id)
        <input type="checkbox" name="{{ $nameInput }}[]" value="{{ $id }}" style="display:none;" checked>
    @endforeach

    <div class="row g-2 mb-3">
        <div class="col">
            <label for="search-user">Asignar a persona:</label>
            @livewire('users.search-user', [
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'myUserUsingId',
                'tagId' => 'search-user',
            ])
            <ul class="list-group mt-2">
                @forelse($listUsers as $index => $itemUser)
                    <li class="list-group-item" style="padding: .4rem 0.5rem">
                        <div class="row">
                            <div class="col-9">
                                {{ $itemUser->full_name }}
                            </div>
                            <div class="col-3 text-end">
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    wire:click.prevent="deleteUser({{ $index }})"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                       </div>
                    </li>
                @empty
                    <li class="list-group-item">
                        <em>No hay registros</em>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
