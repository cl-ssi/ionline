<div class="card">
    <div class="card-header">
        {{ $requestForm->purchaseMechanism->name }} - <strong>{{ $requestForm->purchaseType->name }}</strong>s
    </div>

    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la OC:</label>
                <input type="text" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la Cotización:</label>
                <input type="text" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-4">
                <label for="">Fecha de la Creación de la OC:</label>
                <input type="date" class="form-control form-control-sm" max={{Carbon\Carbon::today()}}>
            </fieldset>
            <fieldset class="form-group col-sm-10">
                <label for="for_description">Descripción de la compra:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" required>
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
          <fieldset class="form-group col-sm-3">
                <label for="">Monto de la OC:</label>
                <input type="number" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-3">
                <label for="">Fecha Estimada de Entrega:</label>
                <input type="date" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Orden de Compra</label>
                <input type="file" class="form-control-file" id="forFile" name="" >
            </fieldset>
        </div>

        @if($requestForm->purchase_type_id == 1)

        @endif

        @endif

    </div>

</div>