<div class="form-row">
@include('layouts.bt4.partials.flash_message')

    <fieldset class="form-group col-6">
        <label>Archivo</label>
        <input class="form-control form-control-sm" type="file" style="padding:2px 0px 0px 2px;" wire:model.live="file">
        <button type="button" wire:click="addItem" class="btn btn-primary btn-sm float-right" wire:target="file" wire:loading.attr="disabled">Agregar</button>
        <div wire:loading wire:target="file">Cargando archivo...</div>
        @error('file') <span class="error">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="form-group col-6">
        <label><br></label>
        <div class="form-row">
            @if($roomBooking)
                @foreach($roomBooking->files as $key => $file) 
                    <fieldset class="form-group col">
                        <a href="{{ route('hotel_booking.download', $file->id) }}" target="_blank">
                            <i class="fas fa-paperclip"></i>
                        </a>
                        <button type="button" wire:click="deleteItem({{$file}})" class="btn btn-danger btn-sm" wire:target="file" wire:loading.attr="disabled">x</button>
                    </fieldset>
                @endforeach
            @endif
        </div>
       
    </fieldset>
</div>