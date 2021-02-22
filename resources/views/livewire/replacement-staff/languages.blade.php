<div>
  <div class="form-row">
      <fieldset class="form-group">
          <label for="">&nbsp;</label>
          <button class="btn text-white btn-info float-right" wire:click.prevent="add({{$i}})">Agregar <i class="fas fa-plus"></i></button>
      </fieldset>
  </div>


  <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.language.store', $replacementStaff) }}" enctype="multipart/form-data">
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

              <fieldset class="form-group col mt">
                  <div class="mb-3">
                    <label for="forFile" class="form-label">Certificado de Idioma</label>
                    <input class="form-control" type="file" name="file[]" accept="application/pdf" required>
                  </div>
              </fieldset>

              <fieldset class="form-group col-md-2">
                  <label for="for_button"><br></label>
                  <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Remover</button>
              </fieldset>
          </div>
          <hr>
      @endforeach

      <button type="submit" class="btn btn-primary float-right">Guardar</button>
</div>
