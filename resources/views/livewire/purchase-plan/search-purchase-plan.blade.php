<div>
    @if($purchasePlans->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm small">
                <thead>
                    <tr class="text-center align-top table-secondary">
                        <th width="6%">
                            ID 
                            <span class="badge bg-info text-dark">Periodo</span>
                        </th>
                        <th width="7%">Estado</th>
                        <th width="7%">Fecha Creación</th>
                        <th width="">Asunto</th>
                        <th width="">Responsable</th>
                        <th width="">Programa</th>
                        <th width="">Aprobaciones</th>
                        <th width=""></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($purchasePlans as $purchasePlan)
                    <tr>
                        <th class="text-center">
                            {{ $purchasePlan->id }}<br>
                            <span class="badge bg-info text-dark">{{ $purchasePlan->period }}</span><br>
                        </th>
                        <td class="text-center">
                            @if($purchasePlan->status == 'save')
                                <span class="badge bg-primary">Guardado</span>
                            @endif
                        </td>
                        <td>{{ $purchasePlan->created_at->format('d-m-Y H:i:s') }}<br></td>
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

                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('purchase_plan.show', $purchasePlan->id) }}"
                                class="btn btn-outline-secondary btn-sm me-1"><i class="fas fa-eye"></i>
                            <a href="{{ route('purchase_plan.edit', $purchasePlan->id) }}"
                                class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i>
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
