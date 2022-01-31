@if($ou->level == 1)
<option value="{{ $ou->id }}" {{ ($ou->id == $organizational_unit_id) ? 'selected' : '' }}>
    @for($i = 1; $i <= $ou->level; $i++)
        - 
    @endfor
    {{ $ou->name }} ({{ $ou->establishment->name?? '' }})
</option>
@endif

@foreach($ou->childs as $child)
    <option value="{{ $child->id }}" {{ ($child->id == $organizational_unit_id) ? 'selected' : '' }}>
        @for($i = 1; $i <= $child->level; $i++)
        - 
        @endfor
        {{ $child->name }}
    </option>

    @include('livewire.organizational_unit_childs', ['ou' => $child])
    
@endforeach