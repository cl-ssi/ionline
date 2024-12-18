<div class="table-responsive">
    <table class="table table-sm table-bordered table-striped table-hover small">
        <thead>
            <tr class="text-center">
                <!-- FORMULARIO -->
                <th>ID</th>
                <th>Estado</th>
                <th>Folio</th>
                <th>Depende Folio</th>
                <th>Fecha Creación</th>
                <th>Tipo de Formulario</th>
                <th>Mecanismo de Compra</th>
                <th>Descripción</th>
                <th>Programa</th>
                <th>Usuario Gestor</th>
                <th>Establecimiento</th>
                <th>Unidad Organizacional</th>
                <th>Comprador</th>
                {{--<th>Items</th>--}}
                <th></th>
                <th>Presupuesto</th>
                <th>Estado Proceso Compra</th>
                <th>Fecha de Aprobación Depto. Abastecimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($request_forms as $requestForm)
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
                <td nowrap>{{ $requestForm->name }}</td>
                <td nowrap>{{ $requestForm->associateProgram ? $requestForm->associateProgram->alias_finance.' '.$requestForm->associateProgram->period : $requestForm->program }}</td>
                <td nowrap>{{ $requestForm->user->fullName }}</td>
                <td nowrap>{{ $requestForm->userOrganizationalUnit->establishment->name }}</td>
                <td nowrap>{{ $requestForm->userOrganizationalUnit->name }}</td>
                <td nowrap>{{ $requestForm->purchasers->first()->fullName ?? 'No asignado' }}</td>
                {{--<td class="text-center">{{ $requestForm->itemRequestForms->count() }}</td>--}}
                <td class="text-right">{{ $requestForm->symbol_currency }}</td>
                <td class="text-right">{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",","") }}</td>
                <td nowrap>
                    @if($requestForm->purchasingProcess)
                        {{ $requestForm->purchasingProcess->status->getLabel() }}
                    @else
                        En proceso
                    @endif
                </td>
                <td nowrap>{{ $requestForm->approved_at ? $requestForm->approved_at->format('d-m-Y H:i:s') : '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>