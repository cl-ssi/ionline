<select class="form-control selectpicker" data-live-search="true" id="forOrganizationalUnit" name="organizationalunit" required data-size="5">
    <option></option>
    @foreach($ouRoots as $ouRoot)
        <option value="{{ $ouRoot->id }}">
        {{ $ouRoot->name }} ({{$ouRoot->establishment->name?? ''}})
        </option>
        @foreach($ouRoot->childs as $child_level_1)
            <option value="{{ $child_level_1->id }}">
            &nbsp;&nbsp;&nbsp;
            {{ $child_level_1->name }} ({{ $child_level_1->establishment->name?? '' }})
            </option>
            @foreach($child_level_1->childs as $child_level_2)
                <option value="{{ $child_level_2->id }}">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{ $child_level_2->name }} ({{ $child_level_2->establishment->name?? '' }})
                </option>
                @foreach($child_level_2->childs as $child_level_3)
                    <option value="{{ $child_level_3->id }}">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $child_level_3->name }} ({{ $child_level_3->establishment->name?? '' }})
                    </option>
                    @foreach($child_level_3->childs as $child_level_4)
                    <option value="{{ $child_level_4->id }}">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $child_level_4->name }} ({{ $child_level_4->establishment->name?? '' }})
                    </option>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    @endforeach
</select>