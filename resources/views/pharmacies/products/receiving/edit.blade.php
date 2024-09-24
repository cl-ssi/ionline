@extends('layouts.bt4.app')

@section('title', 'Editar ingreso')

@section('content')

@include('pharmacies.nav')

<h3>Editar Ingreso</h3>

<form method="POST" action="{{ route('pharmacies.products.receiving.update',$receiving) }}">
    @method('PUT')
	@csrf

    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_date">Fecha</label>
            <input type="date" class="form-control" id="for_date" name="date" required="required" value="{{$receiving->date->format('Y-m-d')}}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_origin">Origen</label>
            <select name="destiny_id" class="form-control selectpicker" data-live-search="true" required="">
                <option value=""></option>
                @foreach ($destines as $key => $destiny)
                <option value="{{$destiny->id}}" @selected($receiving->destiny_id == $destiny->id) >
                    {{$destiny->name}}
                </option>
                @endforeach
            </select>
        </fieldset>
    </div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$receiving->notes}}">
    </fieldset>

    <fieldset class="form-group col-4">
        <label for="for_order_number">Nro. Pedido</label>
        <input type="text" class="form-control" id="for_order_number" placeholder="" name="order_number" value="{{$receiving->order_number}}">
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>
</form>

<hr />

@include('pharmacies.products.receivingitem.create')

@endsection

@section('custom_js')

    <script>
        $( document ).ready(function() {
            document.getElementById("for_barcode").focus();
        });

        document.getElementById("disable_due_date_batch").addEventListener("click", function() {
            var dueDateInput = document.getElementById("for_due_date");
            var batchInput = document.getElementById("for_lote");
            
            if (dueDateInput.readOnly) {
                dueDateInput.value = "";
                batchInput.value = "";
                
            } else {
                dueDateInput.value = "2100-01-01";
                batchInput.value = "S/Lote";
            }

            // Cambia el estado de solo lectura
            dueDateInput.readOnly = !dueDateInput.readOnly;
            batchInput.readOnly = !batchInput.readOnly;
        });
    </script>


@endsection
