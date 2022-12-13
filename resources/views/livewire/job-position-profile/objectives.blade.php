<div>
    <div class="form-row">
        <div class="col-12 col-md-2 mt-2">
            <h5>Funciones</h5> 
        </div>
        <div class="col-12 col-md-10">
            <button class="btn text-white btn-info" wire:click.prevent="add({{$i}})"><i class="fas fa-plus"></i> Agregar</button>
        </div>
    </div>

    <br>

    @foreach($inputs as $key => $value)
        <div class="form-row">
            <fieldset class="form-group col">
                <label for="for_roles_name">Función</label>
                <input type="text" class="form-control" name="roles_name[]" id="for_roles_name" wire:key="value-{{ $value }}" placeholder="" required>
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="for_button"><br></label>
                <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Remover</button>
            </fieldset>
        </div>
    @endforeach
</div>
