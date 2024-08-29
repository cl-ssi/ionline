<div>
<div class="form-row" wire:loading.remove>
  <fieldset class="form-group col-4 col-md-2">
      <label for="for_program_contract_type">Tipo</label>
      <select name="program_contract_type" class="form-control" wire:model.blur="program_contract_type" id="program_contract_type" required>
        <option value=""></option>
        <option value="Mensual">Mensual</option>
        <option value="Horas">Horas</option>
      </select>
  </fieldset>

  <fieldset class="form-group col-8 col-md-2">
        <label for="for_type">Origen Financiamiento</label>
        <select name="type" class="form-control" wire:model.blur="type" required id="type">
            <option value=""></option>
            <option value="Suma alzada">Suma alzada</option>
            <option value="Covid" disabled>Covid (Sólo 2021)</option>
        </select>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
    <label for="for_users">Responsable</label>
    <div id="div_responsable_id" wire:ignore>
    @livewire('search-select-user', ['selected_id' => 'responsable_id', 'required' => 'required'])
    </div>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
    <label for="for_users">Supervisor</label>
    <div id="div_users" wire:ignore>
    @livewire('search-select-user', ['selected_id' => 'users[]', 'required' => 'required'])
    </div>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
    <label for="for_subdirection_ou_id">Subdirección</label>
    <div id="div_subdirection_ou_id" wire:ignore>
      <select class="form-control selectpicker" data-live-search="true" wire:model.blur="subdirection_ou_id" id="subdirection_ou_id" name="subdirection_ou_id" required data-size="5" data-container="#div_subdirection_ou_id">
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
      <select class="form-control selectpicker" data-live-search="true" wire:model.live="responsability_center_ou_id" wire:change="change_responsability_center_ou_id" name="responsability_center_ou_id" id="responsability_center_ou_id" required data-size="5" data-container="#div_responsability_center_ou_id">
        <option value=""></option>
        @if($responsabilityCenters)
            @foreach($responsabilityCenters as $key => $responsabilityCenter)
            <option value="{{$responsabilityCenter->id}}">{{$responsabilityCenter->name}}</option>
            @endforeach
        @endif
      </select>
    </div>
  </fieldset>

  <fieldset class="form-group col-12 col-md-2">
    <label for="for_responsability_center_ou_id">C.Mensuales.Activos</label>
    <input class="form-control" type="text" disabled value="{{$active_mensual_contract_count}}">
  </fieldset>

  <fieldset class="form-group col-12 col-md-2">
    <label for="for_responsability_center_ou_id">C.Horas.Activos</label>
    <input class="form-control" type="text" disabled value="{{$active_horas_contract_count}}">
  </fieldset>

</div>

<div>
    @if (session()->has('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif
</div>

<div class="row" wire:loading.remove>
  @foreach($signatures as $ou_name => $user)
    <fieldset class="form-group col-sm-4">
        <label for="for_users">{{ $ou_name }}</label>
        <input class="form-control" value="{{ $user->fullName }}" readonly>
        <input type="hidden" name="users[]" value="{{ $user->id }}" readonly>
    </fieldset>
  @endforeach
</div>

<div wire:loading>
    Cargando...
</div>

</div>
