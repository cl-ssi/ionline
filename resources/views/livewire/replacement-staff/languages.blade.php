<div>
  <div class="form-row">
      <fieldset class="form-group">
          <label for="">&nbsp;</label>
          <button class="btn text-white btn-info float-right" wire:click.prevent="add({{$i}})">Agregar <i class="fas fa-plus"></i></button>
      </fieldset>
  </div>


  <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.language.store', $replacementStaff) }}">
      @csrf
      @method('POST')
      @foreach($inputs as $key => $value)
          <div class="row">
              <fieldset class="form-group col">
                  <label for="for_language">Idioma</label>
                  <select name="language[]" class="form-control" required>
                      <option value="english">Inglés</option>
                      <option value="french">Francés</option>
                      <option value="german">Alemán</option>
                    </select>
              </fieldset>

              <fieldset class="form-group col">
                  <label for="for_level">Idioma</label>
                  <select name="level[]" class="form-control" required>
                      <option value="basic">Básico</option>
                      <option value="intermediate">Intermedio</option>
                      <option value="advanced">Avanzado</option>
                    </select>
              </fieldset>

              <fieldset class="form-group col">
                  <label for="for_file">Certificado de Experiencia</label>
                  <div class="form-group custom-file col mt">
                      <input type="file" class="custom-file-input"  name="file[]">
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
          </div>
          <hr>
      @endforeach

      <button type="submit" class="btn btn-primary float-right">Guardar</button>
</div>
