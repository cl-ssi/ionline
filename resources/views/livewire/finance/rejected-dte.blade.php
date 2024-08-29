<div>
    @if($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!$rejected)
        <select class="form-control @error('rechazar.'.$dteId) is-invalid @enderror" wire:model="rechazar.{{ $dteId }}">
            <option value=""></option>
            <option value="1">Rechazar</option>
        </select>

        <textarea type="text" class="form-control @error('motivo_rechazo.'.$dteId) is-invalid @enderror" placeholder="motivo rechazo" wire:model="motivo_rechazo.{{ $dteId }}"></textarea>

        <button class="btn btn-primary" type="button" wire:click="rechazarDTE">Rechazar</button>

        @error('rechazar.'.$dteId)
            <div class="invalid-feedback">Debe seleccionar una opción.</div>
        @enderror

        @error('motivo_rechazo.'.$dteId)
            <div class="invalid-feedback">Debe proporcionar un motivo de rechazo.</div>
        @enderror    
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
</div>
