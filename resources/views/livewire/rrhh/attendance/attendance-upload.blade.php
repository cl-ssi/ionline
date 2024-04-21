<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <h1>Cargar Asistencia</h1>
    <p>Exporta archivo de asistencia desde Sirh, utilizando la opción... (no veo que opcion usaste Alejandra, está muy chica la foto)</p>
    <form wire:submit.prevent="save">
        <div class="input-group">
            <input type="file" class="form-control" wire:model="attendanceFile">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Cargar</button>
        </div>
        @error('attendanceFile') <span class="error">{{ $message }}</span> @enderror
    </form>

    <br>

    @if(!empty($missingUserIds))
        <div class="alert alert-warning">
            <p>Los siguientes usuarios no se encontraron en el sistema:</p>
            <ul>
                @foreach($missingUserIds as $userId)
                    <li>{{ $userId }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
