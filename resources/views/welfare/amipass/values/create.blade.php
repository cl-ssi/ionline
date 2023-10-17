@extends('layouts.bt4.app')

@section('title', 'Valor Anual Amipass')

@section('content')

    @include('welfare.nav')

    <h3 class="mb-3">Agregar Valor Anual Amipass</h3>

    <form method="post" action="{{ route('welfare.amipass.value.storeValue') }}" class="form-horizontal">
        @csrf
        <div class="form-row">
            <fieldset class="form-group col-2">
                <label for="for_period">Año (Periodo)*</label>
                <input type="number" class="form-control" name="period" id="for_period" required>
            </fieldset>

            <fieldset class="form-group col-2">
                <label for="Tipo">Tipo:*</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">Seleccionar Tipo</option>
                    <option value="Diurno">Diurno</option>
                    <option value="Turno">Turno</option>
                </select>
            </fieldset>

            <fieldset class="form-group col-2">
                <label for="formGroupValorInput">Valor*</label>
                <input type="number" class="form-control" id="formGroupValueInput" name="amount" required="required"
                    min="5000" max="99999999" autocomplete="off">
            </fieldset>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection
