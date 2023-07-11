<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <select class="form-control" name="user_signer" {{ $required ? 'required' : '' }}>
        <option value="" > Seleccionar Usuario</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}"
                @if ($authority_id == $user->id)
                    selected
                @endif
                >
                @if ($authority_id == $user->id)
                    👑
                @endif
                {{ $user->shortName ?? '' }}
            </option>
        @endforeach
    </select>
</div>
