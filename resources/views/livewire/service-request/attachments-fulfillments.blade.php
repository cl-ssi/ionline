<form method="POST" class="form-horizontal" action="{{ route('rrhh.service-request.fulfillment.attachment.store',$var) }}" enctype="multipart/form-data">
    <div>
        <button class="btn btn-outline-info" wire:click.prevent="add({{$i}})">Agregar <i class="fas fa-plus"></i></button>
        <button type="submit" class="btn btn-outline-primary float-right"><i class="fas fa-upload"></i> Subir</button>
    </div>

        @csrf
        @method('POST')
        @foreach($inputs as $key => $value)
        <div class="form-row">
            <fieldset class="form-group col-md-6">
                <label for="for_training_name">Nombre Archivo</label>
                <input type="text" class="form-control" name="name[]" placeholder="" autocomplete="off" required>
            </fieldset>

            <fieldset class="form-group col-md-5">
                    <label for="forFile" class="form-label">Adjunto</label>
                    <input class="form-control" type="file" name="file[]" accept="application/pdf" autocomplete="off" required>
           </fieldset>

            <fieldset class="form-group col-md-1">
                <label for="for_button"><br></label>
                <button class="btn btn-danger" wire:click.prevent="remove({{$key}})">Remover</button>
            </fieldset>
        </div>
        @endforeach
        
</form>
