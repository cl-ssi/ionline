<div class="card">
    <div class="card-header">
        ORDEN DE COMPRA
        <input type="hidden" name="purchase_type_id" value="{{ $requestForm->purchaseType->id }}">
    </div>

    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la OC:</label>
                <input type="text" class="form-control form-control-sm" name="po_id" value="{{ old('po_id') }}" >
            </fieldset>
            <fieldset class="form-group col-sm-10">
                <label for="for_description">Descripción de la OC:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" required>
            </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group col-sm-3">
              <label for="for_po_sent_date">Fecha OC enviada a proveedor</label>
              <input type="date" class="form-control form-control-sm" id="for_po_sent_date" name="po_sent_date"
                  value="{{ old('po_sent_date') }}">
            </fieldset>
            <fieldset class="form-group col-sm-3">
              <label for="for_po_accepted_date">Fecha OC aceptada</label>
              <input type="date" class="form-control form-control-sm" id="for_po_accepted_date" name="po_accepted_date"
                  value="{{ old('po_accepted_date') }}">
            </fieldset>
            <fieldset class="form-group col-sm-3">
              <label for="for_estimated_delivery_date">Fecha estimada entrega</label>
              <input type="date" class="form-control form-control-sm" id="for_estimated_delivery_date" name="estimated_delivery_date"
                  value="{{ old('estimated_delivery_date') }}">
            </fieldset>
            <fieldset class="form-group col-sm-3">
              <label for="for_po_with_confirmed_receipt_date">Fecha OC con recepción conforme</label>
              <input type="date" class="form-control form-control-sm" id="for_po_with_confirmed_receipt_date" name="po_with_confirmed_receipt_date"
                  value="{{ old('po_with_confirmed_receipt_date') }}">
            </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="for_supplier" >Proveedor</label>
                <select name="supplier_id" id="for_supplier_id" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $supplier->id == old('supplier_id', '') ? 'selected' : '' }} >{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </fieldset>
            <fieldset class="form-group col-2">
                <label for="for_amount">Monto total</label>
                <input type="number" class="form-control form-control-sm amount" id="for_amount" name="po_amount"
                    value="{{ old('po_amount') }}" required>
            </fieldset>
            <fieldset class="form-group col-sm-4">
                <label for="forFile">Adjuntar Orden de Compra (Si procede)</label>
                <input type="file" class="form-control-file" id="forFile" name="oc_file">
            </fieldset>
        </div>
        <button type="submit" class="btn btn-primary float-right" id="save_btn">
          <i class="fas fa-save"></i> Guardar
        </button>
    </div>

</div>