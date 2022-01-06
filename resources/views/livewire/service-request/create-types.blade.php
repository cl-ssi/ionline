<div>
<div class="form-row" wire:loading.remove>
  <fieldset class="form-group col-4 col-md-2">
      <label for="for_program_contract_type">Tipo</label>
      <select name="program_contract_type" class="form-control" wire:model.lazy="program_contract_type" id="program_contract_type" required>
        <option value=""></option>
        <option value="Mensual">Mensual</option>
        <option value="Horas">Horas</option>
      </select>
  </fieldset>

  <fieldset class="form-group col-8 col-md-2">
      <label for="for_type">Origen Financiamiento</label>
      <select name="type" class="form-control" wire:model.lazy="type" required id="type">
        <option value=""></option>
        <option value="Suma alzada">Suma alzada</option>
        <option value="Covid">Covid (Sólo 2021)</option>
      </select>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
    <label for="for_users">Responsable</label>
    <div id="div_responsable_id" wire:ignore>
      <select name="responsable_id" id="responsable_id" class="form-control selectpicker" data-live-search="true" data-size="5" required data-container="#div_responsable_id">
        <option value=""></option>
        @if($users)
          @foreach($users as $key => $user)
            <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
          @endforeach
        @endif
      </select>
    </div>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
    <label for="for_users">Supervisor</label>
    <div id="div_users" wire:ignore>
      <select name="users[]" id="users" class="form-control selectpicker" data-live-search="true" data-size="5" required data-container="#div_users">
        <option value=""></option>
        @if($users)
          @foreach($users as $key => $user)
            <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
          @endforeach
        @endif
      </select>
    </div>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
    <label for="for_subdirection_ou_id">Subdirección</label>
    <div id="div_subdirection_ou_id" wire:ignore>
      <select class="form-control selectpicker" data-live-search="true" wire:model.lazy="subdirection_ou_id" id="subdirection_ou_id" name="subdirection_ou_id" required data-size="5" data-container="#div_subdirection_ou_id">
        <option value=""></option>
        @if($subdirections)
        @foreach($subdirections as $key => $subdirection)
          <option value="{{$subdirection->id}}">{{$subdirection->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
    <label for="for_responsability_center_ou_id">Centro de Responsabilidad</label>
    <div id="div_responsability_center_ou_id" wire:ignore>
      <select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" id="responsability_center_ou_id" required data-size="5" data-container="#div_responsability_center_ou_id">
        <option value=""></option>
        @if($responsabilityCenters)
        @foreach($responsabilityCenters as $key => $responsabilityCenter)
          <option value="{{$responsabilityCenter->id}}">{{$responsabilityCenter->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
  </fieldset>

</div>

<div class="row" wire:loading.remove>
  @foreach($signatureFlows as $key => $signatureFlow)
    <fieldset class="form-group col-sm-4">
        <label for="for_users">{{$key}}</label>
        <select name="users[]" class="form-control" id="{{$key}}" data-live-search="true" required="" data-size="5" readonly>
          @if($users)
            @foreach($users as $key => $user)
              <option value="{{$user->id}}" @if($user->id == $signatureFlow) selected @else disabled @endif >{{$user->getFullNameAttribute()}}</option>
            @endforeach
          @endif
        </select>
    </fieldset>
  @endforeach
</div>

<div wire:loading>
    Cargando...
</div>

</div>
