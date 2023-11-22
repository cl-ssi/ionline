<div>
    @include('layouts.bt5.partials.flash_message')
    <h4 class="mb-3">Solicitud de Baja de Inventario</h4>
    <form wire:submit.prevent="submit">
        <div class="row g-2 g-2 mb-2">
            <label for="motivo">Razón de Solicitud de Baja (Solo llenar en caso de robo o daño del inventario):</label>
            <textarea wire:model.defer="motivo" id="motivo" rows="4" cols="50">{{$inventory->removal_request_reason}}</textarea>
            @error('motivo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
        </div>
    </form>
</div>
