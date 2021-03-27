<div class="row">
<fieldset class="form-group col">
    <label for="for_program_contract_type">Tipo</label>
    <select name="program_contract_type" class="form-control" wire:model.lazy="program_contract_type" id="program_contract_type" required>
      <option value=""></option>
      <option value="Mensual">Mensual</option>
      <option value="Horas">Horas</option>
    </select>
</fieldset>

<fieldset class="form-group col">
    <label for="for_type">Tipo</label>
    <select name="type" class="form-control" wire:model.lazy="type" required id="type">
      <option value="Covid">Honorarios - Covid</option>
      @can('Service Request: additional data rrhh')
        <option value="Suma alzada">Suma alzada</option>
      @endcan
    </select>
</fieldset>
</div>
