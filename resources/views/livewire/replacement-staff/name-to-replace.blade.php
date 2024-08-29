<fieldset class="form-group col-sm">
    <label for="for_end_date">Funcionario a Reemplazar</label>
    <input type="text" class="form-control" name="name_to_replace" id="for_name_to_replace"
        wire:model.live.debounce.700ms="nameToReplace"
        placeholder="Nombre de Reemplazo"
        {{ $disabled }}
        required>
</fieldset>