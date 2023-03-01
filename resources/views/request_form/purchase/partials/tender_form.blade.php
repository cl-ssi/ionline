<div class="card">
    <div class="card-header">
        {{ $requestForm->purchaseMechanism->name }} - <strong>{{ $requestForm->purchaseType->name }}</strong>
        <input type="hidden" name="purchase_type_id" value="{{ $requestForm->purchaseType->id }}">
    </div>
    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-3">
                <label for="for_tender_number">ID de la licitación:</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="for_tender_number" name="tender_number" value="{{ old('tender_number') }}" aria-describedby="btn_licitacion">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-outline-secondary" type="button" id="btn_licitacion">Consultar</button>
                    </div>
                </div>
            </fieldset>
            <fieldset class="form-group col-sm">
                <label for="for_description">Nombre de la licitación:</label>
                <input type="text" class="form-control form-control-sm" id="for_description" name="description" value="{{ old('description') }}" required>
            </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group col-sm-12">
                <label for="for_full_description">Descripción de la licitación:</label>
                <textarea class="form-control form-control-sm" id="for_full_description" name="full_description" rows="3">{!! old('full_description') !!}</textarea>
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
            {{--<fieldset class="form-group col-sm-6">
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
                    <input type="datetime-local" class="form-control form-control-sm" id="for_start_date" name="start_date"
                        value="{{ old('start_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-2">
                    <label for="for_duration">Plazo vigencia en días</label>
                    <input type="number" min="1" class="form-control form-control-sm" id="for_duration" name="duration" value="{{ old('duration') }}">
                </fieldset>--}}
                <fieldset class="form-group col-sm-3">
                    <label for="for_currency">Moneda</label>
                    <input type="text" class="form-control form-control-sm" id="for_currency" name="currency" value="{{ old('currency') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_n_suppliers">N° oferentes</label>
                    <input type="number" min="1" class="form-control form-control-sm" id="for_n_suppliers" name="n_suppliers" value="{{ old('n_suppliers') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_creation_date">Fecha creación</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_creation_date" name="creation_date"
                        value="{{ old('creation_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_closing_date">Fecha cierre</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_closing_date" name="closing_date"
                        value="{{ old('closing_date') }}">
                </fieldset>
            </div>
            <div class="form-row">
                <fieldset class="form-group col-sm-3">
                    <label for="for_initial_date">Fecha inicio</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_initial_date" name="initial_date"
                        value="{{ old('initial_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_final_date">Fecha final</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_final_date" name="final_date"
                        value="{{ old('final_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_pub_answers_date">Fecha pub. respuestas</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_pub_answers_date" name="pub_answers_date"
                        value="{{ old('pub_answers_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_opening_act_date">Fecha acto apertura</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_opening_act_date" name="opening_act_date"
                        value="{{ old('opening_act_date') }}">
                </fieldset>
            </div>
            <div class="form-row">
                <fieldset class="form-group col-sm-3">
                    <label for="for_pub_date">Fecha publicación</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_pub_date" name="pub_date"
                        value="{{ old('pub_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_grant_date">Fecha adjudicación</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_grant_date" name="grant_date"
                        value="{{ old('grant_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_estimated_grant_date">Fecha estimada adjudicación</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_estimated_grant_date" name="estimated_grant_date"
                        value="{{ old('estimated_grant_date') }}">
                </fieldset>
                <fieldset class="form-group col-sm-3">
                    <label for="for_field_visit_date">Fecha visita terreno</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="for_field_visit_date" name="field_visit_date"
                        value="{{ old('field_visit_date') }}">
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

                <fieldset class="form-check" style="display:flex;align-items:center;">
                <input class="form-check-input" type="checkbox" id="for_is_lower_amount" name="is_lower_amount" {{ old('is_lower_amount') ? 'checked' : '' }}>
                <label class="form-check-label" for="for_is_lower_amount">
                    Licitación monto menor a 1000 UTM
                </label>
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
                <fieldset class="form-check" style="display:flex;align-items:center;">
                <input class="form-check-input" type="checkbox" id="for_has_taking_of_reason" name="has_taking_of_reason" {{ old('taking_of_reason_date') ? 'checked' : '' }}>
                <label class="form-check-label" for="for_has_taking_of_reason">
                    Toma de razón
                </label>
                </fieldset>
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
