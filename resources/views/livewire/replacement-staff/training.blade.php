<div>
    <div class="form-row">
        <fieldset class="form-group">
            <label for="">&nbsp;</label>
            <button class="btn text-white btn-info float-right" wire:click.prevent="add({{$i}})">Agregar <i class="fas fa-plus"></i></button>
        </fieldset>
    </div>

    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.training.store', $replacementStaff) }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        @foreach($inputs as $key => $value)
            <div class="form-row">
                <fieldset class="form-group col-md-5">
                    <label for="for_training_name">Nombre Capacitación</label>
                    <input type="text" class="form-control" name="training_name[]" placeholder="" required>
                </fieldset>

                <fieldset class="form-group col-md-2">
                    <label for="for_hours_training">N° de horas</label>
                    <input type="number" min="1" class="form-control" name="hours_training[]" placeholder="" required>
                </fieldset>

                <fieldset class="form-group col mt">
                    <div class="mb-3">
                      <label for="forFile" class="form-label">Certificado de Capacitación</label>
                      <input class="form-control" type="file" name="file[]" accept="application/pdf" required>
                    </div>
                </fieldset>

                <fieldset class="form-group col-md-1">
                    <label for="for_button"><br></label>
                    <button class="btn btn-danger" wire:click.prevent="remove({{$key}})">Remover</button>
                </fieldset>
            </div>
            <hr>
        @endforeach

        @if($count>0)
        <button type="submit" class="btn btn-primary float-right">Guardar</button>
        @endif

    </div>
</div>
