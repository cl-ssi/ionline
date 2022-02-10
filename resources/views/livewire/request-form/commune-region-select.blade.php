<fieldset class="form-group col-sm-6">
    <label for="regiones">Región / Comuna *</label>
    <div class="input-group">

        <select name="region_id" id="for_region_id" class="form-control" wire:model="selectedRegion" required>
            <option value="">Seleccione...</option>
            @foreach($regions as $region)
              <option value="{{ $region->id }}">{{ $region->name }}</option>
            @endforeach
        </select>

        <select name="commune_id" id="for_commune_id" class="form-control" wire:model="selectedCommune" required>
            <option value="">Seleccione...</option>
              @if(!is_null($communes))
                @foreach($communes as $commune)
                  <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                @endforeach
              @endif
        </select>
    </div>
</fieldset>
