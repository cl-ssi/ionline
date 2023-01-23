<div>
    @if($requirement->firstEvent->to_ou_id == auth()->user()->organizationalUnit->id)
        <select wire:model="category_id" wire:change="setCategory" class="form-control">
            <option value="">Seleccione una categoría</option>
            @foreach(auth()->user()->organizationalUnit->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    @elseif($requirement->category_id)
        <span class='badge badge-dark'>
            {{ optional($requirement->category)->name }}
        </span>
    @endif
</div>