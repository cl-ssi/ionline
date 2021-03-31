<div>

  <div class="border border-info rounded">
  <div class="row ml-1 mr-1">

    <fieldset class="form-group col">
        <label for="for_run">Run (sin DV)</label>
        <input type="number" min="1" max="50000000" class="form-control" id="for_user_id" name="user_id" wire:model.lazy="user_id" required>
    </fieldset>

    <fieldset class="form-group col-1">
        <label for="for_dv">Digito</label>
        <input type="text" class="form-control" id="for_dv" name="dv" readonly>
    </fieldset>

    <fieldset class="form-group col-1">
        <label for="">&nbsp;</label>
        <button type="button" id="btn_fonasa" class="btn btn-outline-success">Fonasa&nbsp;</button>
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_name">Nombres</label>
        <input type="text" class="form-control" id="name" placeholder="" name="name" required="required" @if($user) value="{{$user->name}}" @endif>
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_name">Apellido Paterno</label>
        <input type="text" class="form-control" id="name" placeholder="" name="fathers_family" required="required" @if($user) value="{{$user->fathers_family}}" @endif>
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_name">Apellido Materno</label>
        <input type="text" class="form-control" id="name" placeholder="" name="mothers_family" required="required" @if($user) value="{{$user->mothers_family}}" @endif>
    </fieldset>

  </div>

  <div class="row ml-1 mr-1">

    <fieldset class="form-group col-3">
      <label for="for_country_id">Nacionalidad</label>
      <select name="country_id" class="form-control" required>
        <option value=""></option>
        @foreach($countries as $key => $country)
          <option value="{{$country->id}}" @if($user && $user->country_id == $country->id) selected @endif >{{$country->name}}</option>
        @endforeach
      </select>
    </fieldset>

    <fieldset class="form-group col-3">
        <label for="for_address">Dirección</label>
        <input type="text" class="form-control" id="foraddress" placeholder="" name="address" @if($user) value="{{$user->address}}" @endif>
    </fieldset>

    <fieldset class="form-group col-3">
        <label for="for_phone_number">Número telefónico</label>
        <input type="text" class="form-control" id="for_phone_number" name="phone_number"
          @if($user) value="{{$user->phone_number}}" @endif>
    </fieldset>

    <fieldset class="form-group col-3">
        <label for="for_email">Correo electrónico</label>
        <input type="text" class="form-control" id="for_email" name="email"
          @if($user) value="{{$user->email}}" @endif>
    </fieldset>

  </div>


  <!-- <div class="form-row ml-2 mr-1">
      <fieldset class="form-group col-4">
        <label>Banco</label>
        <select name="bank_id" class="form-control">
        <option value="">Seleccionar Banco (opcional)</option>
        @foreach($banks as $bank)
        <option value="{{$bank->id}}" @if($user && $user->bankAccount){{ ($user->bankAccount->bank_id == $bank->id)? 'selected':'' }}@endif>{{$bank->name}}</option>
        @endforeach
      </select>
    </fieldset>


    <fieldset class="form-group col-4">
        <label>Número de Cuenta (opcional)</label>
        <input type="number" name="number" class="form-control"
          @if($user && $user->bankAccount) value="{{ $user->bankAccount->number }}" @endif>
    </fieldset>

    <fieldset class="form-group col-4">
        <label for="for_type">Tipo de cuenta (opcional)</label>
        <select name="type" class="form-control">
          <option value="">Seleccionar tipo de cuenta</option>
          <option value="01" @if($user && $user->bankAccount){{ ($user->bankAccount->type == '01')? 'selected':'' }}@endif>CTA CORRIENTE / CTA VISTA</option>
          <option value="02" @if($user && $user->bankAccount){{ ($user->bankAccount->type == '02')? 'selected':'' }}@endif>CTA AHORRO</option>
          <option value="30" @if($user && $user->bankAccount){{ ($user->bankAccount->type == '30')? 'selected':'' }}@endif>CUENTA RUT</option>
        </select>
    </fieldset>
  </div> -->

</div>
</div>
