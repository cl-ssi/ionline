<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Proveedor</th>
            <th>Factura</th>
            <th>Guía</th>
            <th>Fecha Factura</th>
            <th>Destino</th>
            <th>Fondos</th>
            <th>Acta</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->date->format('d/m/Y') }}</td>
                <td>{{ $purchase->supplier->name }}</td>
                <td>{{ $purchase->invoice }}</td>
                <td>{{ $purchase->despatch_guide }}</td>
                <td>{{ $purchase->invoice_date }}</td>
                <td>{{ $purchase->destination }}</td>
                <td>{{ $purchase->from }}</td>
                <td>{{ $purchase->id }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
