<fieldset class="form-group col-sm-3">
    <label for="profiles">Run / Dígito Verificador</label>
    <div class="input-group">
        <input type="number" class="form-control" name="run"
            wire:model.live.debounce.700ms="run"
            placeholder="Run sin dígito verificador"
            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
            maxlength = "8"
            {{ $disabled }}
            required>
        <div class="input-group-append">
            <span class="input-group-text">{{ $dv }}</span>
            <input type="hidden" name="dv" value="{{ $dv }}">
        </div>
    </div>
</fieldset>
