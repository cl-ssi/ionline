<html lang="es">

@include('documents.templates.partials.head', [
    'title' => 'iOnline - Solicitud de aprobación desde bodega',
])

<body>
    @include('documents.templates.partials.header', [
        'establishment' => auth()->user()->organizationalUnit->establishment,
        'linea1' => auth()->user()->organizationalUnit->establishment->name,
        //'linea2' => 'Departamento de Teconologías de la Información y Comunicaciones',
    ])

    @include('documents.templates.partials.footer', [
        'establishment' => auth()->user()->organizationalUnit->establishment,
    ])

    <main>

        <div style="clear: both;padding-top: 170px;"></div>

        <div class="center" style="text-transform: uppercase;">
            <h2>
                <strong style="text-transform: uppercase;">
                    ACTA DE INGRESO DE ARTICULOS EN BODEGA N° {{ $control->id }}
                </strong>
            </h2>
        </div>

        <div style="clear: both; padding-bottom: 20px"></div>
        <br>
        <br>
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

        <table class="ocho tabla">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cant.</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($control->items as $item)
                    <tr>
                        <td style="width: 1rem; vertical-align: top; center;">
                            <span class="siete">
                                {{ optional($item->product->product)->code }}
                            </span>
                        </td>
                        <td style="width: 1rem; vertical-align: top; center;">
                            {{ $item->quantity }}
                        </td>
                        <td style="vertical-align: top;">
                            {{ optional($item->product->product)->name }}
                            <br>
                            <small>
                                @if ($item->product->barcode)
                                    {{ $item->product->barcode }}
                                    -
                                @endif
                                {{ optional($item->product)->name }}
                            </small>
                        </td>
                        <td class="right" style="vertical-align: top;">
                            {{ money($item->unit_price) }}
                        </td>
                        <td class="right" style="vertical-align: top;">
                            {{ money($item->unit_price * $item->quantity) }}
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td style="center;" colspan="5">
                            <strong>No hay productos</strong>
                        </td>
                    </tr>
                @endforelse


                @if ($control->isPurchaseOrder())
                    <tr>
                        <td colspan="3"></td>
                        <td class="right">
                            <strong>NETO</strong>
                        </td>
                        <td class="right">
                            <strong>{{ money($control->net_total) }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="right" nowrap>
                            @if ($control->purchaseOrder)
                                <strong>
                                    IVA {{ optional($control->purchaseOrder)->tax_percentage }}%
                                </strong>
                            @endif
                        </td>
                        <td class="right">
                            <strong>{{ money($control->total_tax) }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="right">
                            <strong>TOTAL</strong>
                        </td>
                        <td class="right">
                            <strong>{{ money($control->total) }}</strong>
                        </td>
                    </tr>
                @endif
            </tbody>

        </table>


        <p>Se deja constancia que los bienes/servicios se recepcionan conforme de acuerdo a especificaciones técnicas,
            cumple con la calidad técnica, oportunidad y operatividad.</p>

        <p>Para constancia firman/visan:</p>


        <div style="clear: both;padding-top: 156px;"></div>


        <!-- Sección de las aprobaciones -->
        <div class="signature-container">
            @foreach ($control->approvals as $approval)
                <div class="signature">
                    @include('sign.approvation', [
                        'approval' => $approval,
                    ])
                </div>
            @endforeach
        </div>


    </main>

</body>

</html>
