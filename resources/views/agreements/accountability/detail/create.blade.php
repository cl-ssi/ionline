@extends('layouts.app')

@section('title', 'Agregar Detalle')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Agregar Detalle</h3>

<form method="POST" class="form-horizontal" action="{{ route('agreements.accountability.detail.store', [$agreement, $accountability]) }}">
    @csrf
    @method('POST')

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_type">Tipo de Gasto</label>
            <select name="type" id="for_type" class="form-control" required>
                <option>Operacional</option>
                <option>Personal</option>
                <option>Inversión</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_egressNumber">Número Egreso</label>
            <input type="text" class="form-control" id="for_egressNumber" name="egressNumber" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_egressDate">Fecha Egreso</label>
            <input type="date" class="form-control" id="for_egressDate" name="egressDate" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_docNumber">Numero Doc</label>
            <input type="text" class="form-control" id="for_docNumber" name="docNumber" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_docType">Tipo Documento</label>
            <select name="docType" id="for_docType" class="form-control">
                <option value="Boleta">Boleta</option>
                <option value="Boleta Honorario">Boleta Honorario</option>
                <option value="Factura">Factura</option>
                <option value="Liquidación">Liquidación</option>
            </select>
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_docProvider">Proveedor</label>
            <input type="text" class="form-control" id="for_docProvider" name="docProvider" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description" name="description" required>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_paymentType">Forma de pago</label>
            <select name="paymentType" id="for_paymentType" class="form-control" required>
                <option value="Efectivo">Efectivo</option>
                <option value="Cheque">Cheque</option>
                <option value="Transferencia">Transferencia</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_amount">Monto</label>
            <input type="text" class="form-control" id="for_amount" name="amount" required>
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>N. Egreso</th>
            <th>Fecha Egreso</th>
            <th>N. Documento</th>
            <th>Tipo Doc.</th>
            <th>Proveedor</th>
            <th>Descripción</th>
            <th>Tipo de pago</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($accountability->details as $detail)
        <tr>
            <td>{{ $detail->type }}</td>
            <td>{{ $detail->egressNumber }}</td>
            <td>{{ $detail->egressDate->format('d-m-Y') }}</td>
            <td>{{ $detail->docNumber }}</td>
            <td>{{ $detail->docType }}</td>
            <td>{{ $detail->docProvider }}</td>
            <td>{{ $detail->description }}</td>
            <td>{{ $detail->paymentType }}</td>
            <td class="text-right">@numero($detail->amount)</td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection

@section('custom_js')

@endsection
