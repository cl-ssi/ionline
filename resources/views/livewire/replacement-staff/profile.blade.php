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
                  <label for="for_profession">Estamento</label>
                  <select name="profession[]" class="form-control">
                      @foreach($professionManage as $profession)
                          <option value="{{ $profession->id }}">{{ $profession->Name }}</option>
                      @endforeach
                  </select>
              </fieldset>

              <fieldset class="form-group col mt">
                  <label for="for_profession">Profesión</label>
                  <select name="profession[]" class="form-control">
                      <option value="Enfermera">Enfermera</option>
                      <option value="Informatica">Informática</option>
                  </select>
              </fieldset>

              <fieldset class="form-group col mt">
                  <div class="mb-3">
                    <label for="forFile" class="form-label"><br></label>
                    <input class="form-control" type="file" name="file[]" accept="application/pdf" required>
                  </div>
              </fieldset>

              <fieldset class="form-group col-md-2">
                  <label for="for_button"><br></label>
                  <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Remover</button>
              </fieldset>
          </div>
      @endforeach

      <button type="submit" class="btn btn-primary float-right">Guardar</button>
  </form>
</div>
