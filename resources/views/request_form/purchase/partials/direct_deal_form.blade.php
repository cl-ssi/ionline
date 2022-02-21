<div class="card">
    <div class="card-header">
        {{ $requestForm->purchaseMechanism->name }} - <strong>{{ $requestForm->purchaseType->name }}</strong>
        <input type="hidden" name="purchase_type_id" value="{{ $requestForm->purchaseType->id }}">
    </div>

    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-12">
                <label for="for_description">Descripción de la compra:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" required>
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_resol_direct_deal">Nº Resol. trato directo:</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_direct_deal" name="resol_direct_deal" value="{{ old('resol_direct_deal') }}" required>
            </fieldset>
            @if($requestForm->purchase_type_id != 8)
            <fieldset class="form-group col-sm-2">
                <label for="for_resol_contract">Nº Resol. del contrato:</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_contract" name="resol_contract" value="{{ old('resol_contract') }}" required>
            </fieldset>
            <fieldset class="form-group col-sm-2">
                <label for="for_guarantee_ticket">Nº Boleta de garantía:</label>
                <input type="text" class="form-control form-control-sm" id="for_guarantee_ticket" name="guarantee_ticket" value="{{ old('guarantee_ticket') }}" required>
            </fieldset>       
            @endif
            <fieldset class="form-group col">
                <label for="for_supplier">Proveedor</label>
                <select name="supplier_id" id="for_supplier_id" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $supplier->id == old('supplier_id', '') ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <!-- Datos que comparten lo siguiente
        TRATO DIRECTO MAYOR A 30 Y MENOR A 1.000 UTM
        y
        TRATO DIRECTO MAYOR A 1.000 Y MENOR A 5.000 UTM -->
        
        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Resol. Trato Directo</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_direct_deal_file" required>
            </fieldset>

            <!-- <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Orden de Compra (Si procede)</label>
                <input type="file" class="form-control-file" id="forFile" name="">
            </fieldset> -->

            @if($requestForm->purchase_type_id != 8)
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar archivo Res. de Contrato</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_contract_file" required>
            </fieldset>

            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar archivo Boleta de Garantía</label>
                <input type="file" class="form-control-file" id="forFile" name="guarantee_ticket_file" required>
            </fieldset>
            @endif
        </div>
        <button type="submit" class="btn btn-primary float-right" id="save_btn">
                <i class="fas fa-save"></i> Guardar
            </button>


    </div>


</div>