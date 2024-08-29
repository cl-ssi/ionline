<div>

  <div class="card border border-danger">
    <div class="card-body">
      <div class="form-row">

        <fieldset class="form-group col-5 col-md-2">
            <label for="for_run">Run (sin DV)</label>
            <input type="number" min="1" max="50000000" class="form-control" name="user_id" wire:keydown="keydown" wire:model.live="user_id" required>
        </fieldset>

        <fieldset class="form-group col-3 col-md-1">
            <label for="for_dv">Digito</label>
            <input type="text" class="form-control" name="dv" required="required" wire:model="dv" {!!$readonly!!}>
        </fieldset>

        <fieldset class="form-group col-3 col-md-1">
            <label for="">&nbsp;</label>
            <button type="button" id="btn_fonasa" class="btn btn-outline-info" wire:click="getFonasaData()">Fonasa&nbsp;</button>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_name">Nombres</label>
            <input type="text" class="form-control" id="for_name" name="name" required="required" wire:model.live="name">
        </fieldset>

        <fieldset class="form-group col-12 col-md">
            <label for="for_name">Apellido Paterno</label>
            <input type="text" class="form-control" id="for_fathers_family" name="fathers_family" required="required" wire:model.live="fathers_family">
        </fieldset>

        <fieldset class="form-group col-12 col-md">
            <label for="for_name">Apellido Materno</label>
            <input type="text" class="form-control" id="for_mothers_family" name="mothers_family" required="required" wire:model.live="mothers_family">
        </fieldset>

        <fieldset class="form-group col-12 col-md">
            <label for="for_name">Nacionalidad</label>
            <select name="country_id" class="form-control" wire:model.live="country_id" required>
                <option value=""></option>
                @if($countries)
                    @foreach($countries as $key => $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                @endif
            </select>
        </fieldset>

      </div>

      <div class="form-row">

        <fieldset class="form-group col-12 col-md-5">
            <label for="for_address">Dirección*</label>
            <input type="text" class="form-control" id="foraddress" placeholder="Dirección, comuna" name="address" wire:model.live="address" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_commune_id">Comuna</label>
            <select name="commune_id" class="form-control" wire:model.live="commune_id" required>
                <option value=""></option>
                @if($communes)
                    @foreach($communes as $key => $commune)
                    <option value="{{$commune->id}}" >{{$commune->name}}</option>
                    @endforeach
                @endif
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_phone_number">Número telefónico*</label>
            <input type="text" class="form-control" id="for_phone_number" wire:model.live="phone_number"
              name="phone_number" required >
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_email">Correo electrónico*</label>
            <input type="email" class="form-control" id="for_email" required wire:model.live="email"
              name="email" >
        </fieldset>

      </div>
    </div>
  </div>

</div>
