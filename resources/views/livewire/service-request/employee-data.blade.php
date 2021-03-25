<div>

  <div class="border border-info rounded">
  <div class="row ml-1 mr-1">

    <fieldset class="form-group col">
        <label for="for_run">Run (sin DV)</label>
        <input type="number" min="1" max="50000000" class="form-control" id="for_run" name="run" wire:model.lazy="var" required>
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
        <label for="for_name">Nombre completo</label>
        <input type="text" class="form-control" id="name" placeholder="" name="name" required="required" @if($ServiceRequest) value="{{$ServiceRequest->name}}" @endif>
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_contract_type">Tipo de Contrato</label>
        <select name="contract_type" class="form-control" required>
          <option value=""></option>
          <option value="NUEVO">Nuevo</option>
          <option value="ANTIGUO">Antiguo</option>
          <option value="CONTRATO PERM.">Permanente</option>
          <option value="PRESTACION">Prestación</option>
        </select>
    </fieldset>

  </div>

  <div class="row ml-1 mr-1">

    <fieldset class="form-group col-3">
      <label for="for_nationality">Nacionalidad</label>
      <select name="nationality" class="form-control" required>
        <option value=""></option>
        <option value="CHILENA" @if($ServiceRequest) @if($ServiceRequest->nationality == "CHILENA") selected @endif @endif>CHILENA</option>
        <option value="ARGENTINA" @if($ServiceRequest) @if($ServiceRequest->nationality == "ARGENTINA") selected @endif @endif>ARGENTINA</option>
        <option value="VENEZOLANA" @if($ServiceRequest) @if($ServiceRequest->nationality == "VENEZOLANA") selected @endif @endif>VENEZOLANA</option>
        <option value="COLOMBIANA" @if($ServiceRequest) @if($ServiceRequest->nationality == "COLOMBIANA") selected @endif @endif>COLOMBIANA</option>
        <option value="PERUANA" @if($ServiceRequest) @if($ServiceRequest->nationality == "PERUANA") selected @endif @endif>PERUANA</option>
        <option value="BOLIVIANA" @if($ServiceRequest) @if($ServiceRequest->nationality == "BOLIVIANA") selected @endif @endif>BOLIVIANA</option>
        <option value="CUBANA" @if($ServiceRequest) @if($ServiceRequest->nationality == "CUBANA") selected @endif @endif>CUBANA</option>
      </select>
    </fieldset>

    <fieldset class="form-group col-3">
        <label for="for_address">Dirección</label>
        <input type="text" class="form-control" id="foraddress" placeholder="" name="address" @if($ServiceRequest) value="{{$ServiceRequest->address}}" @endif>
    </fieldset>

    <fieldset class="form-group col-3">
        <label for="for_phone_number">Número telefónico</label>
        <input type="text" class="form-control" id="for_phone_number" name="phone_number" 
          @if($ServiceRequest) value="{{$ServiceRequest->phone_number}}" @endif>
    </fieldset>

    <fieldset class="form-group col-3">
        <label for="for_email">Correo electrónico</label>
        <input type="text" class="form-control" id="for_email" name="email" 
          @if($ServiceRequest) value="{{$ServiceRequest->email}}" @endif>
    </fieldset>

  </div>

  <div class="form-row ml-2 mr-1">
      <fieldset class="form-group col-4">
        <label>Banco</label>        
        <select name="bank_id" class="form-control">
        <option value="">Seleccionar Banco</option>
        @foreach($banks as $bank)
        <option value="{{$bank->id}}" @if($ServiceRequest){{ ($ServiceRequest->bank_id == $bank->id)? 'selected':'' }}@endif>{{$bank->name}}</option>
        @endforeach
      </select>
    </fieldset>
    

    <fieldset class="form-group col-4">
        <label>Número de Cuenta</label>
        <input type="number" name="account_number" class="form-control"
          @if($ServiceRequest) value="{{ $ServiceRequest->account_number }}" @endif>
    </fieldset>

    <fieldset class="form-group col-4">
        <label for="for_pay_method">Tipo de cuenta</label>
        <select name="pay_method" class="form-control">
          <option value="">Seleccionar tipo de cuenta</option>
          <option value="01" @if($ServiceRequest){{ ($ServiceRequest->pay_method == '01')? 'selected':'' }}@endif>CTA CORRIENTE / CTA VISTA</option>
          <option value="02" @if($ServiceRequest){{ ($ServiceRequest->pay_method == '02')? 'selected':'' }}@endif>CTA AHORRO</option>
          <option value="30" @if($ServiceRequest){{ ($ServiceRequest->pay_method == '30')? 'selected':'' }}@endif>CUENTA RUT</option>
        </select>
    </fieldset>   
  </div>

</div>
</div>
