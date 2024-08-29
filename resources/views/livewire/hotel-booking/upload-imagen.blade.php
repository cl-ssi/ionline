<div class="form-row">
@include('layouts.bt4.partials.flash_message')

    <fieldset class="form-group col-6">
        <label>Archivo</label>
        <input class="form-control form-control-sm" type="file" style="padding:2px 0px 0px 2px;" wire:model.live="imgFile">
        <button type="button" wire:click="addItem" class="btn btn-primary btn-sm float-right" wire:target="imgFile" wire:loading.attr="disabled">Agregar</button>
        <div wire:loading wire:target="imgFile">Cargando archivo...</div>
        @error('imgFile') <span class="error">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="form-group col-6">
        <label><br></label>
        <div class="form-row">
            @if($hotel)
                @foreach($hotel->images as $key => $image) 
                    <fieldset class="form-group col-2">
                        <img src="data:image/png;base64, {{ $image->base64image() }}" class="img-thumbnail">
                        <button type="button" wire:click="deleteItem({{$image}})" class="btn btn-danger btn-sm float-right" wire:target="imgFile" wire:loading.attr="disabled">x</button>
                    </fieldset>
                @endforeach
            @endif

            @if($room)
                @foreach($room->images as $key => $image) 
                    <fieldset class="form-group col-2">
                        <img src="data:image/png;base64, {{ $image->base64image() }}" class="img-thumbnail">
                        <button type="button" wire:click="deleteItem({{$image}})" class="btn btn-danger btn-sm float-right" wire:target="imgFile" wire:loading.attr="disabled">x</button>
                    </fieldset>
                @endforeach
            @endif
        </div>
       
    </fieldset>
</div>
