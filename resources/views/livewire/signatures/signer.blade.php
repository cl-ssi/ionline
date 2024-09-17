<div class="form-row">
    <fieldset class="form-group col-12 col-md-6">
        <label>{{ $selectedDocumentType == 9 ? 'Aprobador' : 'Firmante' }} - Unidad Organizacional</label>
        <select name="ou_id_signer" id="for_ou_id_signer" wire:model.live="organizationalUnit" class="form-control "
            data-live-search="true" data-size="5">
            <option value=''></option>

            @foreach ($ouRoots as $ouRoot)
                <option value="{{ $ouRoot->id }}">
                    {{ $ouRoot->name . ' - ' . $ouRoot->establishment->alias }}
                </option>
                @foreach ($ouRoot->childs as $child_level_1)
                    <option value="{{ $child_level_1->id }}">
                        &nbsp;&nbsp;&nbsp;
                        {{ $child_level_1->name . ' - ' . $ouRoot->establishment->alias }}
                    </option>
                    @foreach ($child_level_1->childs as $child_level_2)
                        <option value="{{ $child_level_2->id }}">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $child_level_2->name . ' - ' . $ouRoot->establishment->alias }}
                        </option>
                        @foreach ($child_level_2->childs as $child_level_3)
                            <option value="{{ $child_level_3->id }}">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                {{ $child_level_3->name . ' - ' . $ouRoot->establishment->alias }}
                            </option>
                            @foreach ($child_level_3->childs as $child_level_4)
                                <option value="{{ $child_level_4->id }}">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $child_level_4->name . ' - ' . $ouRoot->establishment->alias }}
                                </option>
                                @foreach ($child_level_4->childs as $child_level_5)
                                    <option value="{{ $child_level_5->id }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $child_level_5->name . ' - ' . $ouRoot->establishment->alias }}
                                    </option>
                                    @foreach ($child_level_5->childs as $child_level_6)
                                        <option value="{{ $child_level_6->id }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ $child_level_6->name . ' - ' . $ouRoot->establishment->alias }}
                                        </option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach

        </select>
    </fieldset>
    @if (count($users) > 0)
        <fieldset class="form-group col-12 col-md-6">
            <label>{{ $selectedDocumentType == 9 ? 'Aprobador' : 'Firmante' }} - Usuario</label>
            <select name="user_signer" id="for_user_signer" wire:model.live="user" class="form-control" {{ $userRequired }}>
                <option value=''></option>
                @foreach ($users as $user)
                    <option value={{ $user->id }}>{{ $user->fullName }}</option>
                @endforeach
            </select>
        </fieldset>
    @endif
</div>
