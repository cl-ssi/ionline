<div>
    <div class="form-row">
        <fieldset class="form-group">
            <label for="">&nbsp;</label>
            <button class="btn text-white btn-info float-right" wire:click.prevent="add({{$i}})">Agregar <i class="fas fa-plus"></i></button>
        </fieldset>
    </div>


    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.experience.store', $replacementStaff) }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        @foreach($inputs as $key => $value)
            <div class="row">
                <div class="col">
                    <fieldset class="form-group col">
                        <label for="for_previous_experience">Experiencia Laboral</label>
                        <textarea class="form-control" name="previous_experience[]" rows="4"></textarea>
                    </fieldset>

                    <fieldset class="form-group col">
                        <label for="for_performed_functions">Funciones Realizadas</label>
                        <textarea class="form-control" name="performed_functions[]" rows="4"></textarea>
                    </fieldset>
                </div>
                <div class="col">

                    <fieldset class="form-group col mt">
                        <div class="mb-3">
                          <label for="forFile" class="form-label">Certificado de Experiencia</label>
                          <input class="form-control" type="file" name="file[]" accept="application/pdf" required>
                        </div>
                    </fieldset>

                    <fieldset class="form-group col">
                        <label for="for_contact_name">Nombre Contacto</label>
                        <input type="text" class="form-control" name="contact_name[]">
                    </fieldset>

                    <fieldset class="form-group col">
                        <label for="for_contact_telephone">Teléfono Contacto</label>
                        <input type="text" class="form-control" name="contact_telephone[]" placeholder="+569xxxxxxxx">
                    </fieldset>

                    <fieldset class="form-group col-md-2">
                        <label for="for_button"><br></label>
                        <button class="btn btn-danger" wire:click.prevent="remove({{$key}})">Remover</button>
                    </fieldset>
                </div>
            </div>
            <hr>
        @endforeach

        @if($i > 1)
            <button type="submit" class="btn btn-primary float-right">Guardar</button>
        @endif
    </form>
</div>
