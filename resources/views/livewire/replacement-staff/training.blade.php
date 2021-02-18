<div>
    <div class="form-row">
        <fieldset class="form-group">
            <label for="">&nbsp;</label>
            <button class="btn text-white btn-info float-right" wire:click.prevent="add({{$i}})">Agregar <i class="fas fa-plus"></i></button>
        </fieldset>
    </div>

    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.training.store', $replacementStaff) }}">
        @csrf
        @method('POST')
        @foreach($inputs as $key => $value)
            <div class="form-row">
                <fieldset class="form-group col-md-5">
                    <label for="for_training_name">Nombre Capacitación</label>
                    <input type="text" class="form-control" name="training_name[]" placeholder="">
                </fieldset>

                <fieldset class="form-group col-md-2">
                    <label for="for_hours_training">N° de horas</label>
                    <input type="number" min="1" class="form-control" name="hours_training[]" placeholder="">
                </fieldset>

                <fieldset class="form-group col-md-4">
                    <label for="for_file">Certificado de Experiencia</label>
                    <div class="form-group custom-file">
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

                <fieldset class="form-group col-md-1">
                    <label for="for_button"><br></label>
                    <button class="btn btn-danger" wire:click.prevent="remove({{$key}})">Remover</button>
                </fieldset>
            </div>
            <hr>
        @endforeach

        <button type="submit" class="btn btn-primary float-right">Guardar</button>

    </div>
</div>
