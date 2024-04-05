<div>
    <div class="row">
        <div class="col-md-8">
            <h3 class="mb-3">Fondos Fijos</h3>
        </div>
        <div class="col-md-4">
            <a href="{{ route('finance.fixed-fund.create') }}" class="btn btn-primary float-end">Crear nuevo</a>
        </div>
    </div>

    <table class="table-sm table table-bordered">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>Concepto</th>
                <th>Responsable</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($fixedFunds as $fixedFund)
            <tr>
                <td>{{ $fixedFund->period->format('Y-m') }}</td>
                <td>{{ $fixedFund->concept }}</td>
                <td>{{ $fixedFund->user->name }}</td>
                <td class="text-end">{{ money($fixedFund->total) }}</td>
                <td width="45">
                    <a href="{{ route('finance.fixed-fund.edit', $fixedFund) }}" 
                        class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
