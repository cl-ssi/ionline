<html lang="es">

@include('documents.templates.partials.head', [
    'title' => 'iOnline - Solicitud de aprobación desde bodega',
])

<body>
    @include('documents.templates.partials.header', [
        'establishment' => auth()->user()->organizationalUnit->establishment,
        'linea1' => auth()->user()->organizationalUnit->establishment->name,
        'linea2' => 'Departamento de Teconologías de la Información y Comunicaciones',
    ])

    @include('documents.templates.partials.footer', [
        'establishment' => auth()->user()->organizationalUnit->establishment,
    ])

    <main>

        <div style="clear: both;padding-top: 170px;"></div>

        <div class="center" style="text-transform: uppercase;">
            <strong style="text-transform: uppercase;">
                ACTA DE INGRESO Y RECEPCIÓN CONFORME N° {{ $control->id }}
            </strong>
        </div>

        <div style="clear: both; padding-bottom: 20px"></div>
        <br>

        <table class="ocho">
            <tbody>
                <tr>
                    <td width="100"><strong>Bodega:</strong></td>
                    <td>{{ optional($control->store)->name }}</td>
                </tr>
                <tr>
                    <td><strong>Programa:</strong></td>
                    <td>{{ $control->program_name }}</td>
                </tr>
                <tr>
                    <td><strong>Tipo de Ingreso:</strong></td>
                    <td>{{ optional($control->typeReception)->name }}</strong></td>
                </tr>
                <tr>
                    @switch($control->type_reception_id)
                        @case(\App\Models\Warehouse\TypeReception::receiving())
                            <td><strong>Origen:</strong></td>
                            <td>{{ optional($control->origin)->name }}</td>
                        @break

                        @case(\App\Models\Warehouse\TypeReception::receiveFromStore())
                            <td><strong>Bodega Origen:</strong></td>
                            <td>{{ optional($control->originStore)->name }}</td>
                        @break

                        @case(\App\Models\Warehouse\TypeReception::return())
                            <td><strong>Bodega Origen:</strong></td>
                            <td>{{ optional($control->originStore)->name }}</td>
                        @break
                        
                        @case(\App\Models\Warehouse\TypeReception::purchaseOrder())
                            <td><strong>Código OC:</strong></td>
                            <td>{{ $control->po_code }}</td>
                        @break
                    @endswitch
                </tr>
                <tr>
                    <td><strong>Facturas:</strong></td>
                    <td>
                        @if ($control->invoices->count() > 0)
                            @foreach ($control->invoices as $index => $invoice)
                                {{ $invoice->number }} del {{ $invoice->date->format('Y-m-d') }}@if ($index < $control->invoices->count() - 1)
                                ,@else.
                                @endif
                            @endforeach
                        @else
                            No posee
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Nota:</strong></td>
                    <td>{{ $control->note }}</td>
                </tr>
            </tbody>
        </table>

    </main>

</body>

</html>
