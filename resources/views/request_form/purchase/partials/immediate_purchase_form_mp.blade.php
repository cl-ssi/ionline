<div class="card">
    <div class="card-header">
        @if($requestForm->father)
        ORDEN DE COMPRA
        @else
        {{ $requestForm->purchaseMechanism->name }} - <strong>{{ $requestForm->purchaseType->name }}</strong>
        @endif
        <input type="hidden" name="purchase_type_id" value="{{ $requestForm->purchaseType->id }}">
    </div>

    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la OC:</label>
                <input type="text" class="form-control form-control-sm" id="for_po_id" name="po_id" value="{{ old('po_id') }}">
            </fieldset>
            <fieldset class="form-group col-sm-12">
                <label for="for_description">Nombre de la OC:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" readonly>
            </fieldset>
        </div>

        <button type="submit" class="btn btn-primary float-right" id="save_btn">
            <i class="fas fa-save"></i> Guardar
        </button>
    </div>

</div>