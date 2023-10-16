@extends('layouts.bt4.app')

@section('title', 'Crear nuevo funcionario')

@section('content')

@include('mammography.partials.nav')

@if(!request()->get('run'))

<div class="card">
    <h5 class="card-header">Buscar Funcionario</h5>
    <div class="card-body">
        <form method="GET" class="form-horizontal" action="{{ route('mammography.create') }}">
            <div class="form-row">
                <fieldset class="form-group col-md-2 col-8">
                    <label for="for_run">Run</label>
                    <input type="number" class="form-control" name="run" on
                        id="for_run" required placeholder="sin digito">
                </fieldset>

                <fieldset class="form-group col-md-1 col-4">
                    <label for="for_dv">DV</label>
                    <input type="text" class="form-control" name="dv"
                        id="for_dv" required readonly>
                </fieldset>

                <fieldset class="form-group col-md-1 col-4">
                  <label for="for_dv">&nbsp;</label>
                  <button type="submit" class="btn btn-primary">Consultar</button>
                </fieldset>
            </div>
            <!-- <button type="submit" class="btn btn-primary">Consultar</button> -->
        </form>
    </div>
</div>
@else
@if(!$result)
<div class="card">
    <h5 class="card-header">Crear nuevo funcionario</h5>
    <div class="card-body">
        <form method="POST" class="form-horizontal" action="{{ route('mammography.store') }}">
            @csrf
            @method('POST')

            <div class="form-row">
                <fieldset class="form-group col-md-2">
                    <label for="for_run">Run*</label>
                    <input type="number" class="form-control" name="run" on
                        id="for_run" required placeholder="sin digito" value="{{request()->get('run')}}">
                </fieldset>

                <fieldset class="form-group col-md-1">
                    <label for="for_dv">Digito*</label>
                    <input type="text" class="form-control" name="dv" value="{{request()->get('dv')}}"
                        id="for_dv" required readonly>
                </fieldset>

                <fieldset class="form-group col-md-3">
                    <label for="for_name">Nombres*</label>
                    <input type="text" class="form-control" name="name" autofocus
                        id="for_name" required>
                </fieldset>

                <fieldset class="form-group col-md-3">
                    <label for="for_fathers_family">Apellido Paterno*</label>
                    <input type="text" class="form-control" name="fathers_family"
                        id="for_fathers_family" required>
                </fieldset>

                <fieldset class="form-group col-md-3">
                    <label for="for_mothers_family">Apellido Materno*</label>
                    <input type="text" class="form-control" name="mothers_family"
                        id="for_mothers_family" required>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-md-3">
                    <label for="for_establishment">Establecimiento*</label>
                    <select name="establishment_id" id="for_establishment" class="form-control" required>
                        <option value=""></option>
                        <option value="1">HETG</option>
                        <option value="38">DSSI</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-md-6">
                    <label for="for_ortanizationalUnit">Unidad Organizacional</label>
                    <input type="text" class="form-control" name="ortanizationalUnit"
                        id="for_ortanizationalUnit" placeholder="unidad/depto">
                </fieldset>

                <fieldset class="form-group col-md-3">
                    <label for="for_inform_method">Informado a través</label>
                    <select name="inform_method" id="for_inform_method" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="2">Teléfono</option>
                        <option value="3">Correo electrónico</option>
                    </select>
                </fieldset>

            </div>

            <div class="float-right">
                <button type="submit" class="btn btn-primary form-control"><i class="fas fa-save"></i> Crear</button>
            </div>
        </form>
    </div>
</div>

@else
 Funcionario con run {{request()->get('run')}}-{{request()->dv}} ya existe.
@endif
@endif

@endsection

@section('custom_js')
<script type="text/javascript">

    var Fn = {
        // Valida el run con su cadena completa "XXXXXXXX-X"
        validaRun: function(runCompleto) {
            if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test(runCompleto))
                return false;
            var tmp = runCompleto.split('-');
            var digv = tmp[1];
            var run = tmp[0];
            if (digv == 'K') digv = 'k';
            return (Fn.dv(run) == digv);
        },

        // Calcula el dígito verificador
        dv: function(T) {
            var M = 0,
                S = 1;
            for (; T; T = Math.floor(T / 10))
                S = (S + T % 10 * (9 - M++ % 6)) % 11;
            return S ? S - 1 : 'k';
        },

        // Valida que el número sea un entero
        validaEntero: function(value) {
            var RegExPattern = /[0-9]+$/;
            return RegExPattern.test(value);
        },

    }


    // Implementación de la funcionalidad a la vista
    function imprime_dv() {

        // Traspasa el valor a número entero
        var numero = $("#for_run").val();
        numero = numero.split(".").join("");

        // Valida que sea realmente entero
        if (Fn.validaEntero(numero)) {
            $("#for_dv").val(Fn.dv(numero));
        } else {
            $("#for_dv").val("");
        }

        // Formatea el valor del run con sus puntos
        $("#for_run").val(numero);
    }

    // Adiciona la ejecución de la acción al dejar de tipear en el campo
    $("#for_run").keyup(imprime_dv);
</script>


@endsection
