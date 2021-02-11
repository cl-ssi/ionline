<div class="form-row">
    <fieldset class="form-group col-6">
        <label>Firmante - Unidad Organizacional</label>
        <select name="ou_id_signer" for="for_ou_id_signer" wire:model="organizationalUnit" class="form-control " data-live-search="true" required data-size="5">
{{--            <select name="ou_id_signer" for="for_ou_id_signer" wire:model="organizationalUnit" class="form-control selectpicker" data-live-search="true" required data-size="5">--}}
            <option value=''></option>

            @foreach($ouRoots as $ouRoot)
                <option value="{{ $ouRoot->id }}" >
                    {{ $ouRoot->name }}
                </option>
                @foreach($ouRoot->childs as $child_level_1)
                    <option value="{{ $child_level_1->id }}" >
                        &nbsp;&nbsp;&nbsp;
                        {{ $child_level_1->name }}
                    </option>
                    @foreach($child_level_1->childs as $child_level_2)
                        <option value="{{ $child_level_2->id }}" >
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $child_level_2->name }}
                        </option>
                        @foreach($child_level_2->childs as $child_level_3)
                            <option value="{{ $child_level_3->id }}" >
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                {{ $child_level_3->name }}
                            </option>
                            @foreach($child_level_3->childs as $child_level_4)
                                <option value="{{ $child_level_4->id }}" >
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $child_level_4->name }}
                                </option>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach

        </select>
    </fieldset>
    @if(count($users) > 0)
        <fieldset class="form-group col-6">
            <label>Usuario</label>
            <select name="user_signer" wire:model="user" class="form-control" required>
                <option value=''></option>
                @foreach($users as $user)
                    <option value={{ $user->id }}>{{ $user->fullName }}</option>
                @endforeach
            </select>
        </fieldset>
    @endif
</div>
