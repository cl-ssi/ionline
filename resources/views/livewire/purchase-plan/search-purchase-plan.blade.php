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
                                    @if($approval->status == NULL)
                                        <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $approval->organizationalUnit->name }}">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </span>
                                    @endif
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
                                class="btn btn-outline-secondary btn-sm me-1"><i class="fas fa-eye"></i></a>
                            @if($purchasePlan->status == "save")
                            <a href="{{ route('purchase_plan.edit', $purchasePlan->id) }}"
                                class="btn btn-outline-secondary btn-sm me-1"><i class="fas fa-edit"></i> </a>
                            <a href="#" data-href="{{ route('purchase_plan.destroy', $purchasePlan->id) }}" data-id="{{ $purchasePlan->id }}" class="btn btn-outline-secondary btn-sm text-danger" title="Eliminar" data-toggle="modal" data-target="#confirm" role="button">
                                <i class="fas fa-trash"></i></a>
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

    <!-- Modal -->
    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fas fa-exclamation-triangle"></i> Eliminar Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p>Estás por eliminar un plan de compra, este proceso es irreversible.</p>
            <p>Quieres continuar?</p>
            <p class="debug-url"></p>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-danger btn-ok">Eliminar</a>
        </div>
        </div>
    </div>
    </div>
    <!-- Fin Modal -->
</div>
