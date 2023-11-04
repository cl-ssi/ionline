<div>
    @if($purchasePlans->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm small">
                <thead>
                    <tr class="text-center align-top table-secondary">
                        <th width="6%">ID</th>
                        <th width="7%">
                            Fecha Creación
                            <span class="badge bg-info text-dark">Periodo</span>
                        </th>
                        <th width="">Asunto</th>
                        <th width="">Responsable</th>
                        <th width="">Programa</th>
                        <th width="120px">Estado</th>
                        <th width="85px"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($purchasePlans as $purchasePlan)
                    <tr>
                        <th class="text-center">
                            {{ $purchasePlan->id }}<br>
                        </th>
                        <td>
                            {{ $purchasePlan->created_at->format('d-m-Y H:i:s') }}
                            <span class="badge bg-info text-dark">{{ $purchasePlan->period }}</span><br>
                        </td>
                        <td>{{ $purchasePlan->subject }}</td>
                        <td>
                            <b>{{ $purchasePlan->userResponsible->FullName }}</b><br>
                            {{ $purchasePlan->organizationalUnit->name }}<br><br>
                            
                            creado por: <b>{{ $purchasePlan->userCreator->TinnyName }}</b>
                        </td>
                        <td>{{ $purchasePlan->program }}</td>
                        <td class="text-center">
                            @if($purchasePlan->status == 'save')
                                <i class="fas fa-save fa-2x"></i>
                            @else
                                @foreach($purchasePlan->approvals as $approval)
                                    @switch($approval->StatusInWords)
                                        @case('Pendiente')
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </span>
                                            @break
                                        @case('Aprobado')
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: green;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </span>
                                            @break
                                        @case('Rechazado')
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" style="color: tomato;" data-bs-placement="top" title="{{ $approval->sentToOu->name }}">
                                                <i class="fas fa-ban-circle fa-2x"></i>
                                            </span>
                                            @break
                                    @endswitch
                                @endforeach
                            @endif

                            <br>

                            @switch($purchasePlan->status)
                                @case('save')
                                    <span class="badge bg-primary badge-sm">Guardado</span>
                                    @break
                                @case('sent')
                                    <span class="badge bg-secondary badge-sm">Enviado</span>
                                    @break
                                @default
                                    ''
                            @endswitch
                        </td>
                        <td class="text-left">
                            <a href="{{ route('purchase_plan.show', $purchasePlan) }}"
                                class="btn btn-outline-secondary btn-sm mb-1"><i class="fas fa-eye"></i></a>
                            @if($purchasePlan->canEdit())
                            <a href="{{ route('purchase_plan.edit', $purchasePlan->id) }}"
                                class="btn btn-outline-secondary btn-sm mb-1"><i class="fas fa-edit"></i> </a>
                            @endif
                            @if($purchasePlan->canDelete())
                            <button type="button" class="btn btn-outline-secondary btn-sm mb-1 text-danger"
                                onclick="confirm('¿Está seguro que desea borrar el plan de compra ID {{ $purchasePlan->id }}?') || event.stopImmediatePropagation()"
                                wire:click="delete({{ $purchasePlan }})"><i class="fas fa-trash"></i>
                            </button>
                            @endif                        
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            Estimado Usuario: No se encuentran <b>Plan de Compras</b> bajo los parametros consultados.
        </div>
    @endif
</div>
