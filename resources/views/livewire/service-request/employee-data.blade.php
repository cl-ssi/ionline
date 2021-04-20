<div>

  <div class="card border border-danger">
    <div class="card-body">
      <div class="form-row">

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_run">Run (sin DV)</label>
            <input type="number" min="1" max="50000000" class="form-control" id="for_user_id" name="user_id" wire:model.lazy="user_id" required>
        </fieldset>

        <fieldset class="form-group col-3 col-md-1">
            <label for="for_dv">Digito</label>
            <input type="text" class="form-control" id="for_dv" name="dv" readonly>
        </fieldset>

        <fieldset class="form-group col-3 col-md-1">
            <label for="">&nbsp;</label>
            <button type="button" id="btn_fonasa" class="btn btn-outline-info">Fonasa&nbsp;</button>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_name">Nombres</label>
            <input type="text" class="form-control" id="for_name" name="name" required="required" @if($user) value="{{$user->name}}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md">
            <label for="for_name">Apellido Paterno</label>
            <input type="text" class="form-control" id="for_fathers_family" name="fathers_family" required="required" @if($user) value="{{$user->fathers_family}}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md">
            <label for="for_name">Apellido Materno</label>
            <input type="text" class="form-control" id="for_mothers_family" name="mothers_family" required="required" @if($user) value="{{$user->mothers_family}}" @endif>
        </fieldset>

      </div>

      <div class="form-row">

        <fieldset class="form-group col-12 col-md-2">
          <label for="for_country_id">Nacionalidad</label>
          <select name="country_id" class="form-control" required>
            <option value=""></option>
            @foreach($countries as $key => $country)
              <option value="{{$country->id}}" @if($user && $user->country_id == $country->id) selected @endif >{{$country->name}}</option>
            @endforeach
          </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-5">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" id="foraddress" placeholder="Dirección, comuna"
              name="address" @if($user) value="{{$user->address}}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_phone_number">Número telefónico*</label>
            <input type="text" class="form-control" id="for_phone_number" 
              name="phone_number" required @if($user) value="{{$user->phone_number}}" @endif>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_email">Correo electrónico*</label>
            <input type="text" class="form-control" id="for_email" required
              name="email" @if($user) value="{{$user->email}}" @endif>
        </fieldset>

      </div>
    </div>
  </div>
  
</div>