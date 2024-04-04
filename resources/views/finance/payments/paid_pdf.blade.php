@extends('layouts.document')
@section('title', 'Comprobante de Liquidación de Fondo')
@section('content')
    <style>
            .tabla th,
            .tabla td {
                padding: 3px;
                /* Ajusta este valor a tus necesidades */
            }
    </style>

<div class="center diez">
        <strong style="text-transform: uppercase;">
            Comprobante de Liquidación de Fondos
        </strong>
    </div>
    <hr>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<table class="tabla">
    <tr>
        <td>Institución / Área Transaccional</td>
        <td>¿?</td>
    </tr>
    <tr>
        <td>Título</td>
        <td>{{$dte->comparativeRequirement?->devengo_titulo}}</td>
    </tr>
    <tr>
        <td>Descripción</td>
        <td>{{$dte->comparativeRequirement?->devengo_titulo}}</td>
    </tr>
    <tr>
        <td>Periodo de Operación</td>
        <td></td>
        <td>Ejercicio Fiscal</td>
        <td></td>
        <td>ID</td>
        <td>¿?</td>
        <td>Folio</td>
        <td>{{$dte->comparativeRequirement?->efectivo_folio}}</td>
    </tr>
    <tr>
        <td>Fecha y Hora de Aprobación</td>
        <td>{{$dte->tgrPayedDte?->fecha_generacion}}</td>
        <td>Tipo de Transacción</td>
        <td>Creación ¿?</td>
        <td>Tipo de Operación</td>
        <td>{{$dte->tgrPayedDte?->tipo_operacion}}</td>
        <td>Identificación de Transferencia de Datos</td>
        <td>¿?</td>
    </tr>
    <tr>
        <td>Origen del Ajuste</td>
        <td>¿?</td>
        <td>Folio Anterior</td>
        <td>¿?</td>
    </tr>

</table>
<br><br><br>
<table style="border-collapse: collapse; border: 1px solid black;" class="tabla">
    <tr>
        <td>Principal</td>
        <td>{{$dte->tgrPayedDte?->principal}}</td>
    </tr>
    <thead class="tabla" style="background-color: black; color: white;">
        <tr>
            <td>Tipo Documento</td>
            <td>Nº Documento</td>
            <td>Moneda Documento</td>
            <td>Cuenta Contable</td>
            <td>Cuenta Bancaria</td>
            <td>Medio de Pago</td>
            <td>Nº Documento de Pago</td>
            <td>Moneda de Pago</td>
            <td>Monto</td>
        </tr>
    </thead>
    <tbody class="tabla">
        <tr>
            <td>{{$dte->tgrPayedDte?->tipo_documento}}</td>
            <td>{{$dte->tgrPayedDte?->folio_documento}}</td>
            <td>{{$dte->tgrPayedDte?->moneda}}</td>
            <td>{{$dte->tgrAccountingPortfolio?->cuenta_contable}}</td>
            <td>{{$dte->tgrPayedDte?->banco_cta_corriente}}</td>
            <td>{{$dte->tgrPayedDte?->medio_pago}}</td>
            <td>{{$dte->tgrPayedDte?->nro_documento_pago}}</td>
            <td>{{$dte->tgrPayedDte?->moneda}}</td>
            <td>{{$dte->tgrPayedDte?->monto}}</td>
        </tr>        
    </tbody>

</table>

<br><br><br><br><br>

<div>
____________________000000-Inter-pc____________________
                    
</div>
<br>
Usuario Generador


<br><br><br><br><br>

<div>
____________________000000-Inter-pc____________________
                    
</div>
<br>
Usuario Aprobador


@endsection
