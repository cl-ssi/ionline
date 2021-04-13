<div>
  <div class="form-row">
      <fieldset class="form-group">
          <label for="">&nbsp;</label>
          <button class="btn text-white btn-info float-right" wire:click.prevent="add({{$i}})">Agregar <i class="fas fa-plus"></i></button>
      </fieldset>
  </div>

  <form method="POST" class="form-horizontal"
      action="{{ route('replacement_staff.request.technical_evaluation.commission.store', $technicalEvaluation) }}"/>
      @csrf
      @method('POST')
      @foreach($inputs as $key => $value)
          <div class="form-row">
              <fieldset class="form-group col mt">
                  <label for="for_user_id">Integrante</label>
                  <select name="user_id[]" class="form-control">
                      <option value="">Seleccione</option>
                      @foreach($users as $user)
                          <option value="{{ $user->id }}">{{ $user->FullName }}</option>
                      @endforeach
                  </select>
              </fieldset>

              <fieldset class="form-group col mt">
                  <fieldset class="form-group">
                      <label for="for_cargo">Cargo</label>
                      <input type="text" class="form-control" name="cargo"
                          id="for_cargo" readonly>
                  </fieldset>
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
