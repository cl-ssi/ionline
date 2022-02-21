<select class="form-control" 
    id="{{ $selected_id }}" 
    name="{{ $selected_id }}"
    style="font-family:monospace; font-size: 15px;"
    required>
    
    <option></option>
    @if($ouRoot)
        @include('livewire.organizational_unit_childs', ['ou' => $ouRoot])
    @else
        @foreach($ouRoots as $ouRoot)
            @include('livewire.organizational_unit_childs', ['ou' => $ouRoot])
            <option></option>
        @endforeach
    @endif
</select>