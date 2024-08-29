<div>
    <div class="form-row">
        <fieldset class="form-group col-sm">
            <label>Mecanismo de Compra:</label><br>
            <select wire:model.live="selectedPurchaseMechanism" name="purchase_mechanism_id" class="form-control form-control-sm" required>
                <option value="">Seleccione...</option>
                  @foreach($purchaseMechanisms as $purchaseMechanism)
                    <option value="{{ $purchaseMechanism->id }}"
                      @if($requestForm) {{ ($requestForm->purchase_mechanism_id == $purchaseMechanismSelected) ? 'selected' : '' }} @endif>
                      {{ $purchaseMechanism->name }}
                    </option>
                  @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-sm">
            <label>Tipo de Compra:</label><br>
            <select wire:model.live="selectedPurchaseType" name="purchase_type_id" class="form-control form-control-sm" required>
                <option value="">Seleccione...</option>
                  @foreach($purchasesType as $type)
                    <option value="{{$type->id}}">{{ $type->name }}</option>
                  @endforeach
            </select>
        </fieldset>
    </div>

    <button wire:click="savePurchaseMechanism" type="submit" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Guardar</button>

    <!-- <button class="" wire:click="saveContact">Save Contact</button> -->
</div>
