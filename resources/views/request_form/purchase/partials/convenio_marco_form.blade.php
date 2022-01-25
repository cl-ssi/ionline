<div class="card">
    <div class="card-header">
        {{ $requestForm->purchaseMechanism->name }} - <strong>{{ $requestForm->purchaseType->name }}</strong>
    </div>
    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la OC:</label>
                <input type="text" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-3">
                <label for="">Fecha de la Creación de la OC:</label>
                <input type="date" class="form-control form-control-sm" max={{Carbon\Carbon::today()}}>
            </fieldset>
            <fieldset class="form-group col-sm-3">
                <label for="">Fecha de la OC Aceptada:</label>
                <input type="date" class="form-control form-control-sm" max={{Carbon\Carbon::today()}}>
            </fieldset>
            <fieldset class="form-group col-sm-3">
                <label for="">Fecha de la Recepción Conforme:</label>
                <input type="date" class="form-control form-control-sm" max={{Carbon\Carbon::today()}}>
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
        </div>

        @if($requestForm->purchase_type_id == 5)
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">N° Resolución Acuerdo Complementario</label>
                <input type="number" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">N° Resolución Adjudicación</label>
                <input type="number" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">N° Resolución Intención de Compra</label>
                <input type="number" class="form-control form-control-sm">
            </fieldset>
        </div>
        @endif

        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la OC:</label>
                <input type="text" class="form-control form-control-sm">
            </fieldset>
            <fieldset class="form-group col-sm-3">
                <label for="">Fecha de la Creación de la OC:</label>
                <input type="date" class="form-control form-control-sm" max={{Carbon\Carbon::today()}}>
            </fieldset>
            <fieldset class="form-group col-sm-3">
                <label for="">Fecha de la OC Aceptada:</label>
                <input type="date" class="form-control form-control-sm" max={{Carbon\Carbon::today()}}>
            </fieldset>
            <fieldset class="form-group col-sm-3">
                <label for="">Fecha de la Recepción Conforme:</label>
                <input type="date" class="form-control form-control-sm" max={{Carbon\Carbon::today()}}>
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar Orden de Compra</label>
                <input type="file" class="form-control-file" id="forFile" name="" >
            </fieldset>
            @if($requestForm->purchase_type_id == 5)
            <fieldset class="form-group col-sm-6">
                <label for="forFile">N° Res. Acuerdo Complementario</label>
                <input type="file" class="form-control-file" id="forFile" name="" >
            </fieldset>
            <fieldset class="form-group col-sm-6">
                <label for="forFile">N° Res. Adjudicación</label>
                <input type="file" class="form-control-file" id="forFile" name="" >
            </fieldset>
            <fieldset class="form-group col-sm-6">
                <label for="forFile">N° Res. Intención de Compra</label>
                <input type="file" class="form-control-file" id="forFile" name="" >
            </fieldset>
            @endif

        </div>


    </div>
</div>