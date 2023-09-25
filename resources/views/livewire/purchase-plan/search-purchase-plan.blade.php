<div>
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
                    <th width=""></th>
                </tr>
            </thead>
            <tbody>
            @foreach($purchasePlans as $purchasePlan)
                <tr>
                    <td class="text-center">
                        {{ $purchasePlan->id }}<br>
                        <span class="badge bg-info text-dark">{{ $purchasePlan->period }}</span><br>
                    </td>
                    <td>{{ $purchasePlan->status }}<br></td>
                    <td>{{ $purchasePlan->created_at }}<br></td>
                    <td>{{ $purchasePlan->subject }}</td>
                    <td>
                        <b>{{ $purchasePlan->userResponsible->TinnyName }}</b><br>
                        {{ $purchasePlan->organizationalUnit->name }}
                    </td>
                    <td>{{ $purchasePlan->program }}</td>
                    <td class="text-center align-middle">
                        <a href="{{ route('purchase_plan.show', $purchasePlan->id) }}"
                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
