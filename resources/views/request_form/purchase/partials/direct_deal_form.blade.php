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
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la Cotización:</label>
                <input type="text" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-4">
                <label for="">Fecha de la Creación de la OC:</label>
                <input type="date" class="form-control form-control-sm" max={{Carbon\Carbon::today()}} id="for_po_date" name="po_date" value="{{ old('po_date') }}">
            </fieldset>
            <fieldset class="form-group col-sm-10">
                <label for="for_description">Descripción de la compra:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" required>
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
                <label for="">Monto de la OC:</label>
                <input type="number" class="form-control form-control-sm" id="for_amount" name="po_amount" value="{{ old('po_amount') }}" required>
            </fieldset>
            <fieldset class="form-group col-sm-3">
                <label for="">Fecha Estimada de Entrega:</label>
                <input type="date" class="form-control form-control-sm" id="for_estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date') }}" s>
            </fieldset>
        </div>
        <!-- Datos que comparten lo siguiente
        TRATO DIRECTO MAYOR A 30 Y MENOR A 1.000 UTM
        y
        TRATO DIRECTO MAYOR A 1.000 Y MENOR A 5.000 UTM -->
        @if($requestForm->purchase_type_id == 8 or $requestForm->purchase_type_id == 9)
        <div class="form-row">
            <fieldset class="form-group col-sm-3">
                <label for="">N° Resolución Trato Directo:</label>
                <input type="number" class="form-control form-control-sm">
            </fieldset>

            <fieldset class="form-group col-sm-6">
                <label for="for_supplier">Estado de Compra</label>
                <select name="kaka" id="for_supplier_id" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                    <option value="Suministro">Suministro</option>
                    <option value="Compra Inmediata">Compra Inmediata</option>
                </select>
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Trato Directo</label>
                <input type="file" class="form-control-file" id="forFile" name="" required>
            </fieldset>

            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Orden de Compra (Si procede)</label>
                <input type="file" class="form-control-file" id="forFile" name="">
            </fieldset>

            @endif

            @if($requestForm->purchase_type_id == 9)
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar archivo Res. de Contrato</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_contract_file" required>
            </fieldset>

            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar archivo Boleta de Garantía</label>
                <input type="file" class="form-control-file" id="forFile" name="guarantee_ticket_file" required>
            </fieldset>
            @endif


            <button type="submit" class="btn btn-primary float-right" id="save_btn">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>



    </div>


</div>