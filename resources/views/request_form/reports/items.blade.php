<div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover small">
                <thead>
                    <tr class="text-center">
                        <!-- FORMULARIO -->
                        <th>ID</th>
                        <th>Estado Fomulario</th>
                        <th>Folio</th>
                        <th>Depende de Folio</th>
                        <th>Fecha Creación</th>
                        <th>Tipo de Formulario</th>
                        <th>Mecanismo de Compra</th>
                        <th>Descripción</th>
                        <th>Programa</th>
                        <th>Usuario Gestor</th>
                        <th>Unidad Organizacional</th>
                        <th>Comprador</th>
                        <th>Items</th>
                        <th>Moneda</th>
                        <th>Presupuesto</th>
                        <th>Estado Proceso Compra</th>
                        <th>Fecha de Aprobación Depto. Abastecimiento</th>
                        <!-- ITEMS -->
                        @if($type == 'items')
                        <th>N° Item</th>
                        <th>ID</th>
                        <th>Item Presupuestario</th>
                        <th>Artículo</th>
                        <th>UM</th>
                        <th>Especificaciones Técnicas</th>
                        <th>Cantidad</th>
                        <th>Valor U.</th>
                        <th>Impuestos</th>
                        <th>Total Item</th>
                        @else
                        <!-- PASAJES AEREOS -->
                        <th>#</th>
                        <th>ID</th>
                        <th width="70">RUT</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Fecha Nac.</th>
                        <th>Teléfono</th>
                        <th>E-mail</th>
                        <th>Item Pres.</th>
                        <th>Tipo viaje</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha ida</th>
                        <th>Fecha vuelta</th>
                        <th>Equipaje</th>
                        <th>Total pasaje</th>
                        @endif
                        <!-- PROCESO DE COMPRAS -->
                        <th>Estado compra</th>
                        <th>Tipo compra</th>
                        <th>ID Licitación</th>
                        <th>Fechas</th>
                        <th>Orden de compra</th>
                        <th>Proveedor RUT - nombre</th>
                        <th>Cotización</th>
                        <th>N° res.</th>
                        <th>Especificaciones Técnicas (COMPRADOR/PROVEEDOR)</th>
                        <th>Cantidad</th>
                        <th>Unidad de medida</th>
                        <th>Moneda</th>
                        <th>Precio neto</th>
                        <th>Total cargos</th>
                        <th>Total descuentos</th>
                        <th>Total impuesto</th>
                        <th>Monto Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($request_forms as $requestForm)
                    @if($type == 'items')
                        @if($requestForm->purchasingProcess && $requestForm->purchasingProcess->details->count() > 0)
                            @foreach($requestForm->purchasingProcess->details as $key => $detail)
                                <tr>
                                    <td class="text-right" nowrap>{{ $requestForm->id }}</td>
                                    <td class="text-center" nowrap>{{ $requestForm->getStatus() }}</td>
                                    <td class="text-right" nowrap>{{ $requestForm->folio }}</td>
                                    <td class="text-right" nowrap>
                                        @if($requestForm->father)
                                            {{ $requestForm->father->folio }}
                                        @endif
                                    </td>
                                    <td class="text-center" nowrap>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                                    <td nowrap>
                                        {{ $requestForm->SubtypeValue }}
                                    </td>
                                    <td nowrap>
                                        {{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}
                                    </td>
                                    <td nowrap>{{ substr($requestForm->name, 0, 100) }}</td>
                                    <td nowrap>{{ $requestForm->associateProgram ? $requestForm->associateProgram->alias_finance.' '.$requestForm->associateProgram->period : $requestForm->program }}</td>
                                    <td nowrap>{{ $requestForm->user->fullName }}</td>
                                    <td nowrap>{{ $requestForm->userOrganizationalUnit->name }}</td>
                                    <td nowrap>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                                    <td class="text-center">
                                        @if($loop->first)
                                            {{ $requestForm->itemRequestForms->count() }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($loop->first)
                                            {{ $requestForm->symbol_currency }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($loop->first)
                                            {{ $requestForm->estimated_expense }}
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if($loop->first)
                                            @if($requestForm->purchasingProcess)
                                                {{ $requestForm->purchasingProcess->status->getLabel() }}
                                            @else
                                                En proceso
                                            @endif
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if($loop->first)
                                            {{ $requestForm->approved_at ? $requestForm->approved_at->format('d-m-Y H:i:s') : '' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-right">{{ $detail->id ?? '' }}</td>
                                    <td class="text-right" nowrap>{{ $detail->budgetItem ? $detail->budgetItem->fullName() : '' }}</td>
                                    <td nowrap>
                                        @if($detail->product_id)
                                            {{ optional($detail->product)->code }} {{ optional($detail->product)->name }}
                                        @else
                                            {{ $detail->article }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $detail->unit_of_measurement }}</td>
                                    <td nowrap>{{ substr($detail->specification, 0, 100) }}</td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-right">{{ $detail->unit_value }}</td>
                                    <td class="text-center">{{ $detail->tax }}</td>
                                    <td class="text-right">{{ $detail->expense }}</td>
                                    <td class="text-center" nowrap>
                                        {{ $detail->pivot->getStatus() }}
                                    </td>
                                    <td class="text-center" nowrap>{{ $detail->pivot->getPurchasingTypeName() }}</td>
                                    <td nowrap>{{ $detail->pivot->tender ? $detail->pivot->tender->tender_number : '-' }}</td>
                                    <td align="center" nowrap>
                                        @if($detail->pivot->tender)
                                        <button type="button" class="badge badge-pill badge-dark popover-item" id="detail-{{$detail->id}}" rel="popover"><i class="fas fa-info"></i></button>
                                        <div class="popover-list-content" style="display:none;">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha creación <span class="badge badge-light">{{ $detail->pivot->tender->creation_date ? $detail->pivot->tender->creation_date->format('d-m-Y H:i') : '-' }}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha cierre <span class="badge badge-light">{{$detail->pivot->tender->closing_date ? $detail->pivot->tender->closing_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha inicio <span class="badge badge-light">{{$detail->pivot->tender->initial_date ? $detail->pivot->tender->initial_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha final <span class="badge badge-light">{{$detail->pivot->tender->final_date ? $detail->pivot->tender->final_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha publicación respuestas <span class="badge badge-light">{{$detail->pivot->tender->pub_answers_date ? $detail->pivot->tender->pub_answers_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha acto apertura <span class="badge badge-light">{{$detail->pivot->tender->opening_act_date ? $detail->pivot->tender->opening_act_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha publicación <span class="badge badge-light">{{$detail->pivot->tender->pub_date ? $detail->pivot->tender->pub_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha adjudicación <span class="badge badge-light">{{$detail->pivot->tender->grant_date ? $detail->pivot->tender->grant_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha estimada adjudicación <span class="badge badge-light">{{$detail->pivot->tender->estimated_grant_date ? $detail->pivot->tender->estimated_grant_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha visita terreno <span class="badge badge-light">{{$detail->pivot->tender->field_visit_date ? $detail->pivot->tender->field_visit_date->format('d-m-Y H:i') : '-'}}</span></li>
                                            </ul>
                                        </div>
                                        @endif</td>
                                    <td nowrap>{{ $detail->pivot->tender && $detail->pivot->tender->oc ? $detail->pivot->tender->oc->po_id : ($detail->pivot->immediatePurchase ? $detail->pivot->immediatePurchase->po_id : '-') }}</td>
                                    <td nowrap>{{ $detail->pivot->tender && $detail->pivot->tender->supplier ? $detail->pivot->tender->supplier->run. ' - '.$detail->pivot->tender->supplier->name : $detail->pivot->supplier_run.' - '.$detail->pivot->supplier_name }}</td>
                                    <td nowrap>{{ $detail->pivot->immediatePurchase ? $detail->pivot->immediatePurchase->cot_id : '-'}}</td>
                                    <td>{{ $detail->pivot->directDeal ? $detail->pivot->directDeal->resol_direct_deal : '-'}}</td>
                                    <td nowrap>Comprador: {{ substr($detail->specification, 0, 100) }} // proveedor: {{ substr($detail->pivot->supplier_specifications, 0, 100) }}</td>
                                    <td align="right">{{ $detail->pivot->quantity }}</td>
                                    <td>{{ $detail->unit_of_measurement }}</td>
                                    <td>{{ $detail->pivot->tender ? $detail->pivot->tender->currency : '' }}</td>
                                    <td align="right">{{ $detail->pivot->unit_value }}</td>
                                    <td align="right">{{ $detail->pivot->charges }}</td>
                                    <td align="right">{{ $detail->pivot->discounts }}</td>
                                    <td>{{ $detail->pivot->tax ?? $detail->tax }}</td>
                                    <td align="right">{{ $detail->pivot->expense }}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($requestForm->itemRequestForms as $key => $detail)
                                <tr>
                                    <td class="text-right" nowrap>{{ $requestForm->id }}</td>
                                    <td class="text-center" nowrap>{{ $requestForm->getStatus() }}</td>
                                    <td class="text-right" nowrap>{{ $requestForm->folio }}</td>
                                    <td class="text-right" nowrap>
                                        @if($requestForm->father)
                                            {{ $requestForm->father->folio }}
                                        @endif
                                    </td>
                                    <td class="text-center" nowrap>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                                    <td nowrap>
                                        {{ $requestForm->SubtypeValue }}
                                    </td>
                                    <td nowrap>
                                        {{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}
                                    </td>
                                    <td nowrap>{{ substr($requestForm->name, 0, 100) }}</td>
                                    <td nowrap>{{ $requestForm->associateProgram ? $requestForm->associateProgram->alias_finance.' '.$requestForm->associateProgram->period : $requestForm->program }}</td>
                                    <td nowrap>{{ $requestForm->user->fullName }}</td>
                                    <td nowrap>{{ $requestForm->userOrganizationalUnit->name }}</td>
                                    <td nowrap>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                                    <td class="text-center">
                                        @if($loop->first)
                                            {{ $requestForm->itemRequestForms->count() }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($loop->first)
                                            {{ $requestForm->symbol_currency }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($loop->first)
                                            {{ $requestForm->estimated_expense }}
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if($loop->first)
                                            @if($requestForm->purchasingProcess)
                                                {{ $requestForm->purchasingProcess->status->getLabel() }}
                                            @else
                                                {{ $requestForm->getStatus() }}
                                            @endif
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if($loop->first)
                                            {{ $requestForm->approved_at ? $requestForm->approved_at->format('d-m-Y H:i:s') : '' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-right">{{ $detail->id ?? '' }}</td>
                                    <td class="text-right" nowrap>{{ $detail->budgetItem ? $detail->budgetItem->fullName() : '' }}</td>
                                    <td nowrap>
                                        @if($detail->product_id)
                                            {{ optional($detail->product)->code }} {{ optional($detail->product)->name }}
                                        @else
                                            {{ $detail->article }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $detail->unit_of_measurement }}</td>
                                    <td nowrap>{{ substr($detail->specification, 0, 100) }}</td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-right">{{ $detail->unit_value }}</td>
                                    <td class="text-center">{{ $detail->tax }}</td>
                                    <td class="text-right">{{ $detail->expense }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @endif
                    @else
                        @if($requestForm->purchasingProcess && $requestForm->purchasingProcess->detailsPassenger->count() > 0)
                            @foreach($requestForm->purchasingProcess->detailsPassenger as $key => $detail)
                                <tr>
                                    <td class="text-right" nowrap>{{ $requestForm->id }}</td>
                                    <td class="text-center" nowrap>{{ $requestForm->getStatus() }}</td>
                                    <td class="text-right" nowrap>{{ $requestForm->folio }}</td>
                                    <td class="text-right" nowrap>
                                        @if($requestForm->father)
                                            {{ $requestForm->father->folio }}
                                        @endif
                                    </td>
                                    <td class="text-center" nowrap>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                                    <td nowrap>
                                        {{ $requestForm->SubtypeValue }}
                                    </td>
                                    <td nowrap>
                                        {{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}
                                    </td>
                                    <td nowrap>{{ substr($requestForm->name, 0, 100) }}</td>
                                    <td nowrap>{{ $requestForm->associateProgram ? $requestForm->associateProgram->alias_finance.' '.$requestForm->associateProgram->period : $requestForm->program }}</td>
                                    <td nowrap>{{ $requestForm->user->fullName }}</td>
                                    <td nowrap>{{ $requestForm->userOrganizationalUnit->name }}</td>
                                    <td nowrap>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                                    <td class="text-center">
                                        @if($loop->first)
                                            {{ $requestForm->passengers->count() }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($loop->first)
                                            {{ $requestForm->symbol_currency }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($loop->first)
                                            {{ $requestForm->estimated_expense }}
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if($loop->first)
                                            @if($requestForm->purchasingProcess)
                                                {{ $requestForm->purchasingProcess->status->getLabel() }}
                                            @else
                                                En proceso
                                            @endif
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if($loop->first)
                                            {{ $requestForm->approved_at ? $requestForm->approved_at->format('d-m-Y H:i:s') : '' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-right">{{ $detail->id ?? '' }}</td>
                                    <td nowrap>{{ number_format($detail->run, 0, ",", ".") }}-{{ $detail->dv }}</td>
                                    <td nowrap>{{ $detail->name }}</td>
                                    <td nowrap>{{ $detail->fathers_family }} {{ $detail->mothers_family }}</td>
                                    <td nowrap>{{ $detail->birthday ? $detail->birthday->format('d-m-Y') : '' }}</td>
                                    <td nowrap>{{ $detail->phone_number }}</td>
                                    <td nowrap>{{ $detail->email }}</td>
                                    <td nowrap>{{ $detail->budgetItem ? $detail->budgetItem->fullName() : '' }}</td>
                                    <td nowrap>{{ $detail->roundTripName }}</td>
                                    <td nowrap>{{ $detail->origin }}</td>
                                    <td nowrap>{{ $detail->destination }}</td>
                                    <td nowrap>{{ $detail->departure_date->format('d-m-Y H:i') }}</td>
                                    <td nowrap>{{ $detail->return_date ? $detail->return_date->format('d-m-Y H:i') : '' }}</td>
                                    <td nowrap>{{ $detail->baggageName }}</td>
                                    <td align="right">{{ $detail->unit_value }}</td>
                                    <td class="text-center" nowrap>
                                        {{ $detail->pivot->getStatus() }}
                                    </td>
                                    <td class="text-center" nowrap>{{ $detail->pivot->getPurchasingTypeName() }}</td>
                                    <td nowrap>{{ $detail->pivot->tender ? $detail->pivot->tender->tender_number : '-' }}</td>
                                    <td align="center" nowrap>
                                        @if($detail->pivot->tender)
                                        <button type="button" class="badge badge-pill badge-dark popover-item" id="detail-{{$detail->id}}" rel="popover"><i class="fas fa-info"></i></button>
                                        <div class="popover-list-content" style="display:none;">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha creación <span class="badge badge-light">{{ $detail->pivot->tender->creation_date ? $detail->pivot->tender->creation_date->format('d-m-Y H:i') : '-' }}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha cierre <span class="badge badge-light">{{$detail->pivot->tender->closing_date ? $detail->pivot->tender->closing_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha inicio <span class="badge badge-light">{{$detail->pivot->tender->initial_date ? $detail->pivot->tender->initial_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha final <span class="badge badge-light">{{$detail->pivot->tender->final_date ? $detail->pivot->tender->final_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha publicación respuestas <span class="badge badge-light">{{$detail->pivot->tender->pub_answers_date ? $detail->pivot->tender->pub_answers_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha acto apertura <span class="badge badge-light">{{$detail->pivot->tender->opening_act_date ? $detail->pivot->tender->opening_act_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha publicación <span class="badge badge-light">{{$detail->pivot->tender->pub_date ? $detail->pivot->tender->pub_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha adjudicación <span class="badge badge-light">{{$detail->pivot->tender->grant_date ? $detail->pivot->tender->grant_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha estimada adjudicación <span class="badge badge-light">{{$detail->pivot->tender->estimated_grant_date ? $detail->pivot->tender->estimated_grant_date->format('d-m-Y H:i') : '-'}}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">Fecha visita terreno <span class="badge badge-light">{{$detail->pivot->tender->field_visit_date ? $detail->pivot->tender->field_visit_date->format('d-m-Y H:i') : '-'}}</span></li>
                                            </ul>
                                        </div>
                                        @endif</td>
                                    <td nowrap>{{ $detail->pivot->tender && $detail->pivot->tender->oc ? $detail->pivot->tender->oc->po_id : ($detail->pivot->immediatePurchase ? $detail->pivot->immediatePurchase->po_id : '-') }}</td>
                                    <td nowrap>{{ $detail->pivot->tender && $detail->pivot->tender->supplier ? $detail->pivot->tender->supplier->run. ' - '.$detail->pivot->tender->supplier->name : $detail->pivot->supplier_run.' - '.$detail->pivot->supplier_name }}</td>
                                    <td nowrap>{{ $detail->pivot->immediatePurchase ? $detail->pivot->immediatePurchase->cot_id : '-'}}</td>
                                    <td>{{ $detail->pivot->directDeal ? $detail->pivot->directDeal->resol_direct_deal : '-'}}</td>
                                    <td nowrap>Comprador: {{ substr($detail->specification, 0, 100) }} // proveedor: {{ substr($detail->pivot->supplier_specifications, 0, 100) }}</td>
                                    <td align="right">{{ $detail->pivot->quantity }}</td>
                                    <td>{{ $detail->unit_of_measurement }}</td>
                                    <td>{{ $detail->pivot->tender ? $detail->pivot->tender->currency : '' }}</td>
                                    <td align="right">{{ $detail->pivot->unit_value }}</td>
                                    <td align="right">{{ $detail->pivot->charges }}</td>
                                    <td align="right">{{ $detail->pivot->discounts }}</td>
                                    <td>{{ $detail->pivot->tax ?? $detail->tax }}</td>
                                    <td align="right">{{ $detail->pivot->expense }}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($requestForm->passengers as $key => $detail)
                                <tr>
                                    <td class="text-right" nowrap>{{ $requestForm->id }}</td>
                                    <td class="text-center" nowrap>{{ $requestForm->getStatus() }}</td>
                                    <td class="text-right" nowrap>{{ $requestForm->folio }}</td>
                                    <td class="text-right" nowrap>
                                        @if($requestForm->father)
                                            {{ $requestForm->father->folio }}
                                        @endif
                                    </td>
                                    <td class="text-center" nowrap>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                                    <td nowrap>
                                        {{ $requestForm->SubtypeValue }}
                                    </td>
                                    <td nowrap>
                                        {{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}
                                    </td>
                                    <td nowrap>{{ substr($requestForm->name, 0, 100) }}</td>
                                    <td nowrap>{{ $requestForm->associateProgram ? $requestForm->associateProgram->alias_finance.' '.$requestForm->associateProgram->period : $requestForm->program }}</td>
                                    <td nowrap>{{ $requestForm->user->fullName }}</td>
                                    <td nowrap>{{ $requestForm->userOrganizationalUnit->name }}</td>
                                    <td nowrap>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                                    <td class="text-center">
                                        @if($loop->first)
                                            {{ $requestForm->passengers->count() }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($loop->first)
                                            {{ $requestForm->symbol_currency }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($loop->first)
                                            {{ $requestForm->estimated_expense }}
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if($loop->first)
                                            @if($requestForm->purchasingProcess)
                                                {{ $requestForm->purchasingProcess->status->getLabel() }}
                                            @else
                                                {{ $requestForm->getStatus() }}
                                            @endif
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if($loop->first)
                                            {{ $requestForm->approved_at ? $requestForm->approved_at->format('d-m-Y H:i:s') : '' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-right">{{ $detail->id ?? '' }}</td>
                                    <td nowrap>{{ number_format($detail->run, 0, ",", ".") }}-{{ $detail->dv }}</td>
                                    <td nowrap>{{ $detail->name }}</td>
                                    <td nowrap>{{ $detail->fathers_family }} {{ $detail->mothers_family }}</td>
                                    <td nowrap>{{ $detail->birthday ? $detail->birthday->format('d-m-Y') : '' }}</td>
                                    <td nowrap>{{ $detail->phone_number }}</td>
                                    <td nowrap>{{ $detail->email }}</td>
                                    <td nowrap>{{ $detail->budgetItem ? $detail->budgetItem->fullName() : '' }}</td>
                                    <td nowrap>{{ $detail->roundTripName }}</td>
                                    <td nowrap>{{ $detail->origin }}</td>
                                    <td nowrap>{{ $detail->destination }}</td>
                                    <td nowrap>{{ $detail->departure_date->format('d-m-Y H:i') }}</td>
                                    <td nowrap>{{ $detail->return_date ? $detail->return_date->format('d-m-Y H:i') : '' }}</td>
                                    <td nowrap>{{ $detail->baggageName }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>