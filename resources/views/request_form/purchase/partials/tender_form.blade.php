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
                <label for="for_description">Nombre y descripción de la licitación:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" required>
            </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="for_status">Estado de la Licitación</label>
                <select name="status" id="for_status" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                    <option value="adjudicada" {{ old('status', '') == 'adjudicada' ? 'selected' : '' }}>Adjudicada</option>
                    <option value="desierta" {{ old('status', '') == 'desierta' ? 'selected' : '' }}>Desierta / Revocada</option>
                </select>
            </fieldset>
        </div>
        <div id="adjudicada" style="display: none;">
            <div class="form-row">
                <fieldset class="form-group col-sm-6">
                    <label for="for_supplier">Proveedor</label>
                    <select name="supplier_id" id="for_supplier_id" class="form-control form-control-sm selectpicker" data-live-search="true" title="Seleccione...">
                        <option value="">Seleccione...</option>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $supplier->id == old('supplier_id', '') ? 'selected' : '' }}>{{ $supplier->run }}-{{ $supplier->dv }} &rarr; {{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-sm-2">
                <label for="for_start_date">Fecha inicio</label>
                <input type="date" class="form-control form-control-sm" id="for_start_date" name="start_date"
                    value="{{ old('start_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-2">
                    <label for="for_duration">Plazo vigencia en días</label>
                    <input type="number" min="1" class="form-control form-control-sm" id="for_duration" name="duration" value="{{ old('duration') }}">
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-sm-4">
                    <label for="for_resol_administrative_bases">Nº Resol. de las Bases Administrativas:</label>
                    <input type="text" class="form-control form-control-sm" id="for_resol_administrative_bases" name="resol_administrative_bases" value="{{ old('resol_administrative_bases') }}">
                </fieldset>

                <fieldset class="form-group col-sm-4">
                    <label for="for_resol_adjudication">Nº Resol. de Adjudicación:</label>
                    <input type="text" class="form-control form-control-sm" id="for_resol_adjudication" name="resol_adjudication" value="{{ old('resol_adjudication') }}">
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

                <fieldset class="form-group col-sm-4">
                <label for="for_guarantee_ticket_exp_date">Fecha vencimiento boleta de garantía:</label>
                <input type="date" class="form-control form-control-sm" id="for_guarantee_ticket_exp_date" name="guarantee_ticket_exp_date"
                    value="{{ old('guarantee_ticket_exp_date') }}">
                </fieldset>
                @endif
                <!-- Licitacion LR MAYOR-->
                @if(in_array($requestForm->purchase_type_id, [16,17,18]))
                <fieldset class="form-group col-sm-4">
                <label for="for_taking_of_reason_date">Fecha Toma de Razón:</label>
                <input type="date" class="form-control form-control-sm" id="for_taking_of_reason_date" name="taking_of_reason_date"
                    value="{{ old('taking_of_reason_date') }}">
                </fieldset>

                <fieldset class="form-group col-sm-4">
                    <label for="for_memo_number">Nº Oficio:</label>
                    <input type="text" class="form-control form-control-sm" id="for_memo_number" name="memo_number" value="{{ old('memo_number') }}">
                </fieldset>              
                @endif
            </div>

            <hr>

            <div class="form-row">
                <fieldset class="form-group col-sm-6">
                    <label for="forFile">Adjuntar archivo Res. Bases Administrativas</label>
                    <input type="file" class="form-control-file" id="forFile" name="resol_administrative_bases_file">
                </fieldset>
                <fieldset class="form-group col-sm-6">
                    <label for="forFile">Adjuntar archivo Res. Adjudicación</label>
                    <input type="file" class="form-control-file" id="forFile" name="resol_adjudication_deserted_file">
                </fieldset>
            </div>
            <!-- Licitacion LP/LQ -->
            @if(in_array($requestForm->purchase_type_id, [14,15,16,17,18]))
            <div class="form-row">
                <fieldset class="form-group col-sm-6">
                    <label for="forFile">Adjuntar archivo Res. de Contrato</label>
                    <input type="file" class="form-control-file" id="forFile" name="resol_contract_file">
                </fieldset>
                <fieldset class="form-group col-sm-6">
                    <label for="forFile">Adjuntar archivo Boleta de Garantía</label>
                    <input type="file" class="form-control-file" id="forFile" name="guarantee_ticket_file">
                </fieldset>
            </div>
            @endif
            <!-- Licitacion LR MAYOR-->
            @if(in_array($requestForm->purchase_type_id, [16,17,18]))
            <div class="form-row">
                <fieldset class="form-group col-6">
                    <label for="forFile">Adjuntar archivo Oficio</label>
                    <input type="file" class="form-control-file" id="forFile" name="memo_file">
                </fieldset>
            </div>
            @endif

            @if(!$requestForm->father && Str::contains($requestForm->subtype, 'inmediata'))
            @include('request_form.purchase.partials.implements_immediate_purchase_form')
            @endif
        </div>
        <div id="desierta" style="display: none;">
            <div class="form-row">
                <fieldset class="form-group col-sm-2">
                    <label for="for_resol_deserted">Nº Resol. Desierta:</label>
                    <input type="text" class="form-control form-control-sm" id="for_resol_deserted" name="resol_deserted" value="{{ old('resol_deserted') }}">
                </fieldset>
                <fieldset class="form-group col-sm-10">
                    <label for="for_justification">Justificación:</label>
                    <input type="text" class="form-control form-control-sm" id="for_justification" name="justification" value="{{ old('justification') }}">
                </fieldset>
            </div>
        </div>

        <button type="submit" class="btn btn-primary float-right" id="save_btn">
            <i class="fas fa-save"></i> Guardar
        </button>
    </div>
</div>
