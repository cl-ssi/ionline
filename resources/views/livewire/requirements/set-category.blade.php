<div>
    @if($requirement->firstEvent)
        @if($requirement->firstEvent->to_ou_id == auth()->user()->organizationalUnit->id)
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" title="Categoría">
                        <i class="fas fa-copyright"></i>
                    </span>
                </div>
                <select wire:model.live="category_id" wire:change="setCategory" class="form-control">
                    <option value="">Seleccione una categoría</option>
                    @foreach(auth()->user()->organizationalUnit->categories->sortBy('name') as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        @elseif($requirement->category_id)
            <span class='badge badge-dark'>
                <i class="fas fa-copyright"></i> {{ optional($requirement->category)->name }}
            </span>
        @endif
    @endif
</div>