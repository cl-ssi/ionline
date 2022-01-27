<div class="card">
    <div class="card-header">
        {{ $requestForm->purchaseMechanism->name }} - <strong>{{ $requestForm->purchaseType->name }}</strong>
        <input type="hidden" name="purchase_type_id" value="{{ $requestForm->purchaseType->id }}">
    </div>
    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_tender_number">ID de la licitación:</label>
                <input type="text" class="form-control form-control-sm" id="for_tender_number" name="tender_number" value="{{ old('tender_number') }}">
            </fieldset>
            <fieldset class="form-group col-sm-10">
                <label for="for_description">Descripción de la licitación:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" required>
            </fieldset>
        </div>

        <div class="form-row">
            <!-- <fieldset class="form-group col-sm-2">
              <label for="for_date">Fecha</label>
              <input type="date" class="form-control form-control-sm" id="for_date" name="date"
                  value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
          </fieldset> -->

            <fieldset class="form-group col-sm-4">
                <label for="for_resol_administrative_bases">Nº Resol. de las Bases Administrativas:</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_administrative_bases" name="resol_administrative_bases" value="{{ old('resol_administrative_bases') }}" required>
            </fieldset>

            <fieldset class="form-group col-sm-4">
                <label for="for_resol_adjudication">Nº Resol. de Adjudicación:</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_adjudication" name="resol_adjudication" value="{{ old('resol_adjudication') }}">
            </fieldset>

            <fieldset class="form-group col-sm-4">
                <label for="for_resol_deserted">Nº Resol. Desierta:</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_deserted" name="resol_deserted" value="{{ old('resol_deserted') }}">
            </fieldset>
        </div>
        <div class="form-row">
            <!-- Licitacion LP/LQ -->
            @if(in_array($requestForm->purchase_type_id, [14,15,16,17,18]))
            <fieldset class="form-group col-sm-4">
                <label for="for_resol_contract">Nº Resol. de Contrato:</label>
                <input type="text" class="form-control form-control-sm" id="for_resol_contract" name="resol_contract" value="{{ old('resol_contract') }}">
            </fieldset>

            <fieldset class="form-group col-sm-4">
                <label for="for_guarantee_ticket">Nº Boleta de Garantía:</label>
                <input type="text" class="form-control form-control-sm" id="for_guarantee_ticket" name="guarantee_ticket" value="{{ old('guarantee_ticket') }}">
            </fieldset>
            @endif
            <!-- Licitacion LR MAYOR-->
            @if(in_array($requestForm->purchase_type_id, [16,17,18]))
            <fieldset class="form-group col-sm-4">
                <label for="for_has_taking_of_reason">&nbsp;</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="for_has_taking_of_reason" name="has_taking_of_reason" {{ old('has_taking_of_reason') ? 'checked' : '' }}>
                    <label class="form-check-label" for="for_has_taking_of_reason">
                        Cuenta con Toma de razón
                    </label>
                </div>
            </fieldset>
            @endif
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
                <label for="for_status">Estado de la Licitación</label>
                <select name="status" id="for_status" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                    <option value="adjudicada" {{ old('status', '') == 'adjudicada' ? 'selected' : '' }}>Adjudicada</option>
                    <option value="desierta" {{ old('status', '') == 'desierta' ? 'selected' : '' }}>Desierta</option>
                </select>
            </fieldset>
        </div>

        <hr>

        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar archivo Res. Bases Administrativas</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_administrative_bases_file" required>
            </fieldset>
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar archivo Res. Adjudicación/Desierta</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_adjudication_deserted_file" required>
            </fieldset>
        </div>
        <!-- Licitacion LP/LQ -->
        @if(in_array($requestForm->purchase_type_id, [14,15,16,17,18]))
        <div class="form-row">
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar archivo Res. de Contrato</label>
                <input type="file" class="form-control-file" id="forFile" name="resol_contract_file" required>
            </fieldset>
            <fieldset class="form-group col-sm-6">
                <label for="forFile">Adjuntar archivo Boleta de Garantía</label>
                <input type="file" class="form-control-file" id="forFile" name="guarantee_ticket_file" required>
            </fieldset>
        </div>
        @endif
        <!-- Licitacion LR MAYOR-->
        @if(in_array($requestForm->purchase_type_id, [16,17,18]))
        <div class="form-row">
            <fieldset class="form-group col-12">
                <label for="forFile">Adjuntar archivo Res. Toma de Razón</label>
                <input type="file" class="form-control-file" id="forFile" name="taking_of_reason_file" required>
            </fieldset>
        </div>
        @endif

        <button type="submit" class="btn btn-primary float-right" id="save_btn">
            <i class="fas fa-save"></i> Guardar
        </button>

        </form>
    </div>
</div>
