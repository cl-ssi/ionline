<html>
    <head>
        <title>
            {{ $purchaseOrder->code }}
        </title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }
            .tabla_encabezado {
                border-collapse: collapse;
                width: 100%;
                font-size: 12px;
            }
            .tabla_encabezado th {
                text-align: left;
            }
            .tabla1 {
                border: 1px solid black;
                width: 100%;
                font-size: 12px;
                margin-bottom: 1em;
            }
            .tabla1 th {
                text-align: left;
            }
            .tabla_items {
                border: 1px solid black;
                width: 100%;
                font-size: 10px;
                border-collapse: collapse; 
            }
            .tabla_items th {
                text-align: left;
                padding: 2px;
            }
            .tabla_items td {
                text-align: left;
                padding: 2px;
            }

            .table_wrapper {
                border-collapse: collapse;
                margin-left: 45%;
                width: 55%;
            }
            .table_wrapper td {
                vertical-align: top;
                padding: 0px;
            }

            .tabla_totales {
                border: 1px solid black;
                font-size: 10px;
                margin-bottom: 1em;
                border-collapse: collapse;
                width: 100%;
                font-weight: bold;
            }
            .tabla_totales th {
                text-align: left;
                padding: 2px;
            }
            .tabla_totales td {
                text-align: right;
                padding: 2px;
            }

            .anotaciones {
                font-size:.7em!important;
                margin-bottom: 2em;
            }
            .footertext {
                font-size:.6em!important;
            }

        </style>
    </head>
    <body>
        <table class="tabla_encabezado">
            <tr>
                <th width="90px">Rut:</th>
                <th width="240px">{{ $purchaseOrder->json->Listado[0]->Comprador->RutUnidad }}</th>
                <td></td>
                <th width="120px">Demandante:</th>
                <td>{{ $purchaseOrder->json->Listado[0]->Comprador->NombreOrganismo }}</td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td></td>
                <td></td>
                <th>Unidad de Compra:</th>
                <td>{{ $purchaseOrder->json->Listado[0]->Comprador->NombreUnidad }}</td>
            </tr>
            <tr>
                <th>Demandante:</th>
                <td>{{ $purchaseOrder->json->Listado[0]->Comprador->DireccionUnidad }}</td>
                <td></td>
                <th>Fecha Envio OC.:</th>
                <td>{{ $purchaseOrder->dateFormat($purchaseOrder->json->Listado[0]->Fechas->FechaEnvio) }}</td>
            </tr>
            <tr>
                <th>Teléfono:</th>
                <td>{{ $purchaseOrder->json->Listado[0]->Comprador->FonoContacto }}</td>
                <td></td>
                <th>Estado:</th>
                <td>{{ $purchaseOrder->json->Listado[0]->Estado }}</td>
            </tr>
        </table>

        <center>
            <h3>ORDEN DE COMPRA Nº: {{ $purchaseOrder->code }}</h3>
        </center>

        <table class="tabla1">
            <tr>
                <th width="80px">
                    SEÑOR (ES)
                </th>
                <th width="15px">:</th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->Proveedor->Nombre }} - 
                    {{ $purchaseOrder->json->Listado[0]->Proveedor->MailContacto }}
                </td>
            </tr>
            <tr>
                <th>
                    RUT
                </th>
                <th>:</th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->Proveedor->RutSucursal }}
                </td>
            </tr>
        </table>


        <table class="tabla1">
            <tr>
                <th width="200px">
                NOMBRE ORDEN DE COMPRA :
                </th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->Nombre }}
                </td>
            </tr>
            <tr>
                <th width="">
                FECHA ENTREGA PRODUCTOS :
                </th>
                <td>
                    {{ $purchaseOrder->dateFormat($purchaseOrder->json->Listado[0]->DatosPago->FechaEntregaProductos) }}
                </td>
            </tr>
            <tr>
                <th width="">
                DIRECCION DE ENVIO FACTURA :
                </th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->DatosPago->CorreoResponsable }} /  
                    {{ $purchaseOrder->json->Listado[0]->DatosPago->DireccionFacturacion }}, 
                    {{ $purchaseOrder->json->Listado[0]->DatosPago->ComunaComprador }}, 
                    {{ $purchaseOrder->json->Listado[0]->DatosPago->RegionComprador }} 
                </td>
            </tr>
            <tr>
                <th width="">
                DIRECCION DE DESPACHO :
                </th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->DatosPago->DireccionDespacho }}
                </td>
            </tr>
            <tr>
                <th width="">
                METODO DE DESPACHO :
                </th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->DatosPago->TipoDespacho }}
                </td>
            </tr>
            <tr>
                <th width="">
                FORMA DE PAGO :
                </th>
                <td>
                    {{ $purchaseOrder->json->Listado[0]->DatosPago->FormaPago }}
                </td>
            </tr>

        </table>

        <table class="tabla_items">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cantidad / Unidad</th>
                    <th>Especificaciones Comprador</th>
                    <th>Especificaciones Proveedor</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>Cargos</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->json->Listado[0]->Items->Listado as $item)
                <tr style="border: 1px solid black;">
                    <td>{{ $item->CodigoCategoria }}</td>
                    <td>{{ $item->Producto }}</td>
                    <td style="text-align: right;">{{ $item->Cantidad }} {{ $item->Unidad }}</td>
                    <td>{{ $item->EspecificacionComprador }}</td>
                    <td>{{ $item->EspecificacionProveedor }}</td>
                    <td style="text-align: right;">{{ moneyDecimal($item->PrecioNeto) }}</td>
                    <td style="text-align: right;">{{ money($item->TotalDescuentos) }}</td>
                    <td style="text-align: right;">{{ money($item->TotalCargos) }}</td>
                    <td style="text-align: right;">{{ money($item->Cantidad * $item->PrecioNeto) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <table class="table_wrapper">
            <tr>
                <td class="anotaciones" width="50%">
                    <br>
                    {{ $purchaseOrder->json->Listado[0]->TipoJustificacion }}
                </td>
                <td>
                    <table class="tabla_totales">

                        <tr>
                            <th>Neto</th>
                            <td>$</td>
                            <td>{{ money($purchaseOrder->json->Listado[0]->TotalNeto) }}</td>
                        </tr>
                        <tr>
                            <th>Dcto.</th>
                            <td>$</td>
                            <td>{{ money($purchaseOrder->json->Listado[0]->Descuentos) }}</td>
                        </tr>
                        <tr>
                            <th>Cargos</th>
                            <td>$</td>
                            <td>{{ money($purchaseOrder->json->Listado[0]->Cargos) }}</td>
                        </tr>
                        <tr>
                            <th>Subtotal</th>
                            <td>$</td>
                            <td>{{ money($purchaseOrder->json->Listado[0]->TotalNeto) }}</td>
                        </tr>
                        <tr>
                            <th>{{ $purchaseOrder->json->Listado[0]->PorcentajeIva }}% IVA</th>
                            <td>$</td>
                            <td>{{ money($purchaseOrder->json->Listado[0]->Impuestos) }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>$</td>
                            <td>{{ money($purchaseOrder->json->Listado[0]->Total) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br><br>

        <div class="anotaciones">
            <strong>Disponibilidad Presupuestaria:</strong>
            @if($purchaseOrder->json->Listado[0]->Financiamiento)
                Esta orden de compra cuenta con disponibilidad presupuestaria. 
                Validación realizada con el folio del compromiso SIGFE: 
                {{ $purchaseOrder->json->Listado[0]->Financiamiento }}
            @endif
        </div>
        <div class="anotaciones">
            <strong>Fuente Financiamiento:</strong> 
            {{ $purchaseOrder->json->Listado[0]->Financiamiento }}
            
        </div>
        <div class="anotaciones">
            <strong>Observaciones:</strong><br>
            {{ $purchaseOrder->json->Listado[0]->Descripcion }}
        </div>

        <div class="footertext">
            Derechos del Proveedor del Mercado Público<br>
            1. Derecho a entender los resultados de cada proceso.<br>
            2. Derecho a participar en mercado público igualitariamente y sin discriminaciones arbitrarias.<br>
            3. Derecho a exigir el pago convenido en el tiempo y forma establecido en las bases de licitación.<br>
            4. Derecho a impugnar los actos de los organismos compradores del sistema.<br>
            5. A difundir y publicitar sus productos y servicios entre los organismos compradores, previo o no relacionados con procesos de compra o contratación en desarrollo.<br>
            6. Derecho a inscribirse en el registro oficial de contratistas de la Administración del Estado, ChileProveedores y a no entregar documentación que se encuentre acreditada en éste.<br>
            Especificaciones<br><br>
            Para revisar en detalle sus derechos como proveedor visite https://www.mercadopublico.cl/Portal/MP2/secciones/leyes-y-reglamento/derechos-del-proveedor.htm
        </div>
    </body>
</html>