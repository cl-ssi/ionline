<div>


    <select class="form-control" wire:model="selectedEstablishment">
        <option value="">Seleccionar Establecimiento</option>
        @foreach ($establishments as $establishment)
            <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
        @endforeach
    </select>
    <button class="btn btn-primary" wire:click="saveEstablishment">Guardar</button>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>
