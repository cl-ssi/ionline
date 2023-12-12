<div>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered small">
            <thead>
                <tr class="text-center">
                    <th width="5%">ID</th>
                    <th width="9%">Fecha Creación</th>
                    <th width="26%">Asunto</th>
                    <th width="26%">Causa, Necesidad o Problemática</th>
                    <th width="26%">Creador / Unidad Organizacional</th>
                    <th width="8%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($identifyNeeds as $identifyNeed)
                <tr>
                    <td class="text-center">{{ $identifyNeed->id }}</td>
                    <td class="text-center">{{ $identifyNeed->created_at->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $identifyNeed->subject }}</td>
                    <td>{{ Str::limit($identifyNeed->reason, 120) }}</td>
                    <td class="text-center">
                        {{ $identifyNeed->user->FullName }} <br>
                        <b><small>{{ $identifyNeed->organizationalUnit->name }}</small></b>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('identify_need.edit', $identifyNeed) }}"
                            class="btn btn-outline-secondary btn-sm mb-1"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Editar DNC">
                            <i class="fas fa-edit"></i> 
                        
                        </a>
                        <a href="{{-- route('purchase_plan.edit', $purchasePlan->id) --}}"
                            class="btn btn-outline-secondary btn-sm mb-1"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Proyecto">
                            <i class="bi bi-cash-coin"></i> 
                        </a>
                        <a href="{{-- route('purchase_plan.edit', $purchasePlan->id) --}}"
                            class="btn btn-outline-danger btn-sm mb-1"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
