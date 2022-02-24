<div class="card">
    <div class="card-header">
        {{ $requestForm->purchaseMechanism->name }} - <strong>{{ $requestForm->purchaseType->name }}</strong>
        <input type="hidden" name="purchase_type_id" value="{{ $requestForm->purchaseType->id }}">
    </div>
    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la OC:</label>
                <input type="text" class="form-control form-control-sm" name="po_id" value="{{ old('po_id') }}">
            </fieldset>
            <fieldset class="form-group col-sm-10">
                <label for="for_description">Descripción de la OC:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" required>
            </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group col-sm-3">
              <label for="for_po_accepted_date">Fecha OC aceptada</label>
              <input type="date" class="form-control form-control-sm" id="for_po_accepted_date" name="po_accepted_date"
                  value="{{ old('po_accepted_date') }}">
            </fieldset>
            <fieldset class="form-group col-sm-2">
                <label for="for_days_type_delivery">Días</label>
                <select name="days_type_delivery" id="for_days_type_delivery" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                    <option value="hábiles" {{ old('days_type_delivery', '') == 'hábiles' ? 'selected' : '' }}>Hábiles</option>
                    <option value="corridos" {{ old('days_type_delivery', '') == 'corridos' ? 'selected' : '' }}>Corridos</option>
                </select>
            </fieldset>
            <fieldset class="form-group col-sm-2">
                <label for="for_days_delivery">Plazo entrega en días</label>
                <input type="number" min="1" class="form-control form-control-sm" id="for_days_delivery" name="days_delivery" value="{{ old('days_delivery') }}">
            </fieldset>
            <fieldset class="form-group col-sm-2">
              <label for="for_estimated_delivery_date">Fecha estimada entrega</label>
              <input type="date" class="form-control form-control-sm" id="for_estimated_delivery_date" name="estimated_delivery_date"
                  value="{{ old('estimated_delivery_date') }}"  readonly required>
            </fieldset>
            <fieldset class="form-group col-sm-3">
              <label for="for_po_with_confirmed_receipt_date">Fecha OC con recepción conforme</label>
              <input type="date" class="form-control form-control-sm" id="for_po_with_confirmed_receipt_date" name="po_with_confirmed_receipt_date"
                  value="{{ old('po_with_confirmed_receipt_date') }}">
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="for_supplier">Proveedor</label>
                <select name="supplier_id" id="for_supplier_id" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $supplier->id == old('supplier_id', '') ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </fieldset>
            <fieldset class="form-group col-sm-3">
              <label for="for_po_sent_date">Fecha OC enviada a proveedor</label>
              <input type="date" class="form-control form-control-sm" id="for_po_sent_date" name="po_sent_date"
                  value="{{ old('po_sent_date') }}">
            </fieldset>
            <fieldset class="form-group col-3">
                <label for="for_amount">Monto total</label>
                <input type="number" step="0.01" min="1" class="form-control form-control-sm amount" id="for_amount" name="po_amount"
                    value="{{ old('po_amount') }}" required>
            </fieldset>
        </div>

        @if($requestForm->purchase_type_id == 5)
        <div class="form-row">
            <fieldset class="form-group col-sm-4">
                <label for="for_resol_supplementary_agree">N° Resolución Acuerdo Complementario</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_supplementary_agree" name="resol_supplementary_agree" value="{{ old('resol_supplementary_agree') }}" required>
            </fieldset>
            <fieldset class="form-group col-sm-4">
                <label for="for_resol_awarding">N° Resolución Adjudicación</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_awarding" name="resol_awarding" value="{{ old('resol_awarding') }}" required>
            </fieldset>
            <fieldset class="form-group col-sm-4">
                <label for="for_resol_purchase_intention">N° Resolución Intención de Compra</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_purchase_intention" name="resol_purchase_intention" value="{{ old('resol_purchase_intention') }}" required>
            </fieldset>
        </div>
        @endif

        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Orden de Compra</label>
                <input type="file" class="form-control-file" id="forFile" name="oc_file" required>
            </fieldset>
            @if($requestForm->purchase_type_id == 5)
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Res. Acuerdo Complementario</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_supplementary_agree_file" required>
            </fieldset>
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Res. Adjudicación</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_awarding_file" required>
            </fieldset>
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Res. Intención de Compra</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_purchase_intention" required>
            </fieldset>
            @endif

        </div>

        <button type="submit" class="btn btn-primary float-right" id="save_btn">
            <i class="fas fa-save"></i> Guardar
        </button>
    </div>
</div>