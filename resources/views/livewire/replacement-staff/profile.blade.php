<div>
  <div class="form-row">
      <fieldset class="form-group">
          <label for="">&nbsp;</label>
          <button class="btn text-white btn-info float-right" wire:click.prevent="add({{$i}})">Agregar <i class="fas fa-plus"></i></button>
      </fieldset>
  </div>

  <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.profile.store', $replacementStaff) }}" enctype="multipart/form-data"/>
      @csrf
      @method('POST')
      @foreach($inputs as $key => $value)
          <div class="form-row">
              <fieldset class="form-group col mt">
                  <label for="for_profession">Profesión</label>
                  <select name="profession[]" class="form-control">
                      <option value="Enfermera">Enfermera</option>
                      <option value="Informatica">Informática</option>
                  </select>
              </fieldset>

              <fieldset class="form-group col mt">
                  <label for="for_file"><br></label>
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

              <fieldset class="form-group col-md-2">
                  <label for="for_button"><br></label>
                  <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Remover</button>
              </fieldset>
          </div>
      @endforeach

      <button type="submit" class="btn btn-primary float-right">Guardar</button>
  </form>
</div>
