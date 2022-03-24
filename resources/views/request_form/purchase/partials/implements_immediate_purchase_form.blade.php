<hr>
<input type="hidden" name="purchase_type_id" value="{{ $requestForm->purchaseType->id }}">
<div class="form-row">
    <fieldset class="form-group col-sm-2">
        <label for="for_po_id">ID de la OC:</label>
        <input type="text" class="form-control form-control-sm" id="for_po_id" name="po_id" value="{{ old('po_id') }}" >
    </fieldset>
    <fieldset class="form-group col-sm-10">
        <label for="for_po_description">Nombre de la OC:</label>
        <input type="text" class="form-control form-control-sm" id="for_po_description" name="po_description" value="{{ old('po_description') }}">
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
        <select name="days_type_delivery" id="for_days_type_delivery" class="form-control form-control-sm">
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
            value="{{ old('estimated_delivery_date') }}"  readonly>
    </fieldset>
    <fieldset class="form-group col-sm-3">
        <label for="for_po_sent_date">Fecha OC enviada a proveedor</label>
        <input type="date" class="form-control form-control-sm" id="for_po_sent_date" name="po_sent_date"
            value="{{ old('po_sent_date') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-2">
        <label for="for_amount">Monto total</label>
        <input type="number" step="0.01" min="1" class="form-control form-control-sm amount" id="for_amount" name="po_amount"
            value="{{ old('po_amount') }}">
    </fieldset>
    <fieldset class="form-group col-sm-2">
        <label for="for_destination_warehouse">Bodega destino</label>
        <select name="destination_warehouse" id="for_destination_warehouse" class="form-control form-control-sm">
            <option value="">Seleccione...</option>
            <option value="Servicios Generales" {{ old('destination_warehouse', '') == 'Servicios Generales' ? 'selected' : '' }}>Servicios Generales</option>
            <option value="Farmacia" {{ old('destination_warehouse', '') == 'Farmacia' ? 'selected' : '' }}>Farmacia</option>
            <option value="APS" {{ old('destination_warehouse', '') == 'APS' ? 'selected' : '' }}>APS</option>
        </select>
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-sm-12">
        <label for="for_supplier_specifications">Especificaciones del proveedor</label>
        <input type="text" class="form-control form-control-sm" id="for_supplier_specifications" name="supplier_specifications" value="{{ old('supplier_specifications') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-sm-6">
        <label for="forFile">Adjuntar Orden de Compra (Si procede)</label>
        <input type="file" class="form-control-file" id="forFile" name="oc_file">
    </fieldset>
</div>