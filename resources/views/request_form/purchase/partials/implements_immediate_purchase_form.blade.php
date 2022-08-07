<hr>
<input type="hidden" name="purchase_type_id" value="{{ $requestForm->purchaseType->id }}">
<div class="form-row">
    <fieldset class="form-group col-sm-3">
        <label for="for_po_id">ID de la OC:</label>
        <div class="input-group">
            <input type="text" class="form-control form-control-sm" id="for_po_id" name="po_id" value="{{ old('po_id') }}" aria-describedby="btn_oc">
            <div class="input-group-append">
                <button class="btn btn-sm btn-outline-secondary" type="button" id="btn_oc">Consultar</button>
            </div>
        </div>
    </fieldset>
    <fieldset class="form-group col-sm">
        <label for="for_po_description">Nombre de la OC:</label>
        <input type="text" class="form-control form-control-sm" id="for_po_description" name="po_description" value="{{ old('po_description') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-sm-3">
        <label for="for_po_status">Estado de la OC:</label>
        <input type="text" class="form-control form-control-sm" id="for_po_status" name="po_status" value="{{ old('po_status') }}" >
    </fieldset>
    <fieldset class="form-group col-sm-3">
        <label for="for_po_date">Fecha creación</label>
        <input type="datetime-local" class="form-control form-control-sm" id="for_po_date" name="po_date"
            value="{{ old('po_date') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-sm-3">
        <label for="for_po_accepted_date">Fecha OC aceptada</label>
        <input type="datetime-local" class="form-control form-control-sm" id="for_po_accepted_date" name="po_accepted_date"
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
        <input type="datetime-local" class="form-control form-control-sm" id="for_estimated_delivery_date" name="estimated_delivery_date"
            value="{{ old('estimated_delivery_date') }}"  readonly>
    </fieldset>
    <fieldset class="form-group col-sm-3">
        <label for="for_po_sent_date">Fecha OC enviada a proveedor</label>
        <input type="datetime-local" class="form-control form-control-sm" id="for_po_sent_date" name="po_sent_date"
            value="{{ old('po_sent_date') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-2">
        <label for="for_po_discounts">Descuentos total</label>
        <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="for_po_discounts" name="po_discounts"
            value="{{ old('po_discounts') }}">
    </fieldset>
    <fieldset class="form-group col-2">
        <label for="for_po_charges">Cargos total</label>
        <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="for_po_charges" name="po_charges"
            value="{{ old('po_charges') }}">
    </fieldset>
    <fieldset class="form-group col-2">
        <label for="for_po_net_amount">Neto total</label>
        <input type="number" step="0.01" min="1" class="form-control form-control-sm" id="for_po_net_amount" name="po_net_amount"
            value="{{ old('po_net_amount') }}">
    </fieldset>
    <fieldset class="form-group col-2">
        <label for="for_po_tax_percent">% impuesto</label>
        <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="for_po_tax_percent" name="po_tax_percent"
            value="{{ old('po_tax_percent') }}">
    </fieldset>
    <fieldset class="form-group col-2">
        <label for="for_po_tax_amount">Impuestos total</label>
        <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="for_po_tax_amount" name="po_tax_amount"
            value="{{ old('po_tax_amount') }}">
    </fieldset>
    <fieldset class="form-group col-2">
        <label for="for_amount">Monto total</label>
        <input type="number" step="0.01" min="1" class="form-control form-control-sm amount" id="for_amount" name="po_amount"
            value="{{ old('po_amount') }}">
    </fieldset>
</div>
@if(Str::contains($requestForm->subtype, 'bienes'))
<div class="form-row">
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
@endif
{{--<div class="form-row">
    <fieldset class="form-group col-sm-12">
        <label for="for_supplier_specifications">Especificaciones del proveedor</label>
        <input type="text" class="form-control form-control-sm" id="for_supplier_specifications" name="supplier_specifications" value="{{ old('supplier_specifications') }}">
    </fieldset>
</div>--}}
<div class="form-row">
    <fieldset class="form-group col-sm-5">
        <label for="for_po_supplier_name">Nombre del proveedor</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_name" name="po_supplier_name" value="{{ old('po_supplier_name') }}">
    </fieldset>
    <fieldset class="form-group col-sm-7">
        <label for="for_po_supplier_activity">Actividad del proveedor</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_activity" name="po_supplier_activity" value="{{ old('po_supplier_activity') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-sm-3">
        <label for="for_po_supplier_office_run">RUT de la sucursal</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_office_run" name="po_supplier_office_run" value="{{ old('po_supplier_office_run') }}">
    </fieldset>
    <fieldset class="form-group col-sm-9">
        <label for="for_po_supplier_office_name">Nombre de la sucursal</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_office_name" name="po_supplier_office_name" value="{{ old('po_supplier_office_name') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-sm-4">
        <label for="for_po_supplier_address">Dirección</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_address" name="po_supplier_address" value="{{ old('po_supplier_address') }}">
    </fieldset>
    <fieldset class="form-group col-sm-4">
        <label for="for_po_supplier_commune">Comuna</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_commune" name="po_supplier_commune" value="{{ old('po_supplier_commune') }}">
    </fieldset>
    <fieldset class="form-group col-sm-4">
        <label for="for_po_supplier_region">Región</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_region" name="po_supplier_region" value="{{ old('po_supplier_region') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-sm-4">
        <label for="for_po_supplier_contact_name">Nombre del contacto</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_contact_name" name="po_supplier_contact_name" value="{{ old('po_supplier_contact_name') }}">
    </fieldset>
    <fieldset class="form-group col-sm-3">
        <label for="for_po_supplier_contact_position">Cargo del contacto</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_contact_position" name="po_supplier_contact_position" value="{{ old('po_supplier_contact_position') }}">
    </fieldset>
    <fieldset class="form-group col-sm-2">
        <label for="for_po_supplier_contact_phone">Fono contacto</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_contact_phone" name="po_supplier_contact_phone" value="{{ old('po_supplier_contact_phone') }}">
    </fieldset>
    <fieldset class="form-group col-sm-3">
        <label for="for_po_supplier_contact_email">E-mail contacto</label>
        <input type="text" class="form-control form-control-sm" id="for_po_supplier_contact_email" name="po_supplier_contact_email" value="{{ old('po_supplier_contact_email') }}">
    </fieldset>
</div>
<div class="form-row">
    <fieldset class="form-group col-sm-6">
        <label for="forFile">Adjuntar Orden de Compra (Si procede)</label>
        <input type="file" class="form-control-file" id="forFile" name="oc_file">
    </fieldset>
</div>