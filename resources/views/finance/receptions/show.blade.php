@extends('layouts.document')

@section('title', 'Recepción ' . $reception->id)

@section('linea1', $reception->responsableOu->name)

@section('linea3', 'id: ' . $reception->id . ' - ' . $reception->creator->initials)

@section('content')

    <style>
        .tabla th,
        .tabla td {
            padding: 3px;
            /* Ajusta este valor a tus necesidades */
        }

        .totales {
            margin-left: auto;
            margin-right: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>



    <div style="float: right; width: 300px; padding-top: 66px;">

        <div class="left quince"
            style="padding-left: 2px; padding-bottom: 10px;">
            <strong style="text-transform: uppercase; padding-right: 30px;">
                Número:
            </strong>
            <span class="catorce negrita">{{ $reception->number }}</span>
            @if($reception->internal_number)
                <br>
                <small class="secondary">
                    <b style="padding-right: 20px;">Nº Interno:</b> 
                    {{ $reception->internal_number }}
                </small>
            @endif
        </div>

        <div style="padding-top:5px; padding-left: 2px;">
            Iquique, {{ $reception->date->day }} de {{ $reception->date->monthName }} del {{ $reception->date->year }}
        </div>


    </div>

    <div style="clear: both; padding-bottom: 35px"></div>

    <div class="center diez">
        <strong style="text-transform: uppercase;">
            {{ $reception->receptionType->title }}
        </strong>
    </div>


    <p style="white-space: pre-wrap;">{{ $reception->header_notes }}</p>

    <table class="tabla">
        <tr>
            <th>
                Orden de Compra
            </th>
            <td class="nowrap">
                @if($reception->purchaseOrder)
                    {{ $reception->purchase_order }}
                @else
                    N/A
                @endif
            </td>
            <th>
                Proveedor
            </th>
            <td>
                @if($reception->purchaseOrder)
                    {{ $reception->purchaseOrder->json->Listado[0]->Proveedor->Nombre }}
                @else
                    {{ $reception->dte?->razon_social_emisor }}
                @endif
            </td>
            <th>
                RUT Proveedor
            </th>
            <td class="nowrap">
                @if($reception->purchaseOrder)
                    {{ $reception->purchaseOrder->json->Listado[0]->Proveedor->RutSucursal }}
                @else
                    {{ $reception->dte?->emisor }}
                @endif
            </td>
        </tr>
        <tr>
            <th>
                N° Documento
            </th>
            <td>
                {{ $reception->dte_number }}
            </td>
            <th>
                Tipo de documento
            </th>
            <td>
                {{ $reception->dte_type_name }}
            </td>
            <th>
                Fecha Emisón:
            </th>
            <td>
                {{ $reception->dte_date?->format('d-m-Y') }}
            </td>
        </tr>
    </table>

    <br>

    @if ($reception->items->isNotEmpty())
        <table class="tabla">
            <thead>
                <tr>
                    <th>Producto</th>

                    <th>Cantidad / Unidad</th>

                    @if($reception->items->first()->EspecificacionProveedor)
                        <th>Especificaciones Proveedor</th>
                    @endif

                    @if($reception->dte_type != 'boleta_honorarios')
                    <th>Precio Unitario</th>
                    @endif
                    
                    @if($reception->items->first()->TotalDescuentos)
                        <th>Descuento</th>
                    @endif

                    @if($reception->items->first()->TotalCargos)
                        <th>Cargos</th>
                    @endif

                    @if($reception->dte_type != 'boleta_honorarios')
                    <th>Valor Total</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($reception->items as $item)
                    @if ($item->Cantidad)
                        <tr>
                            <td>{{ $item->Producto }}</td>
                            
                            <td class="center">{{ $item->Cantidad }} / {{ $item->Unidad}} </td>
                            
                            @if($item->EspecificacionProveedor)
                                <td>{{ $item->EspecificacionProveedor }}</td>
                            @endif
                            
                            @if($reception->dte_type != 'boleta_honorarios')
                            <td class="right">{{ moneyDecimal($item->PrecioNeto) }}</td>
                            @endif
                            
                            @if($item->TotalDescuentos)
                                <td class="right">{{ money($item->TotalDescuentos) }}</td>
                            @endif

                            @if($item->TotalCargos)
                                <td class="right">{{ money($item->TotalCargos) }}</td>
                            @endif

                            @if($reception->dte_type != 'boleta_honorarios')
                            <td class="right">{{ moneyDecimal($item->Total) }}</td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <table class="totales">
        @if($reception->dte_type != 'boleta_honorarios')
            @if($reception->neto)
                <tr>
                    <th width="100">Neto</th>
                    <td>$</td>
                    <td width="100"
                        class="right">{{ money($reception->neto) }}</td>
                </tr>
            @endif

            @if ($reception->descuentos AND $reception->descuentos > 0)
                <tr>
                    <th>Dcto.</th>
                    <td>$</td>
                    <td class="right">{{ money($reception->descuentos) }}</td>
                </tr>
            @endif
            
            @if ($reception->cargos and $reception->cargos > 0)
                <tr>
                    <th>Cargos</th>
                    <td>$</td>
                    <td class="right">{{ money($reception->cargos) }}</td>
                </tr>
            @endif

            @if($reception->subtotal)
                <tr>
                    <th>Subtotal</th>
                    <td>$</td>
                    <td class="right">{{ money($reception->subtotal) }}</td>
                </tr>
            @endif

            @if($reception->purchaseOrder)
                <tr>
                    <th>{{ $reception->purchaseOrder->json->Listado[0]->PorcentajeIva }}% IVA</th>
                    <td>$</td>
                    <td class="right">{{ money($reception->iva) }}</td>
                </tr>
            @else
                @if($reception->iva)
                    <tr>
                        <th>IVA</th>
                        <td>$</td>
                        <td class="right">{{ money($reception->iva) }}</td>
                    </tr>
                @endif
            @endif
        @endif

        <tr>
            <th>Total</th>
            <td>$</td>
            <td class="right">
                <b>{{ money($reception->total) }}</b>
            </td>
        </tr>
    </table>

    <p style="white-space: pre-wrap;">{{ $reception->footer_notes }}</p>

    <div style="height: 80px;"></div>

    <!-- Sección de las aprobaciones -->
    <div class="signature-container">
        <div class="signature" style="padding-left: 32px;">
            @if($approval = $reception->approvals->where('position', 'left')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">
            @if($approval = $reception->approvals->where('position', 'center')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
        <div class="signature">
            @if($approval = $reception->approvals->where('position', 'right')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
    </div>
@endsection
