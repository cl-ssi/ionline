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
                        <textarea class="form-control" name="previous_experience[]" rows="5"></textarea>
                    </fieldset>

                    <fieldset class="form-group col">
                        <label for="for_performed_functions">Funciones Realizadas</label>
                        <textarea class="form-control" name="performed_functions[]" rows="4"></textarea>
                    </fieldset>
                </div>
                <div class="col">
                    <fieldset class="form-group col">
                        <label for="for_file">Certificado de Experiencia</label>
                        <div class="form-group custom-file col mt">
                            <input type="file" class="custom-file-input"  name="file[]" required>
                            <label class="custom-file-label" for="customFile">Seleccione el archivo</label>
                        </div>
                    </fieldset>

                    <script>
                        // Add the following code if you want the name of the file appear on select
                        $(".custom-file-input").on("change", function() {
                          var fileName = $(this).val().split("\\").pop();
                          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });
                    </script>

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
</div>
