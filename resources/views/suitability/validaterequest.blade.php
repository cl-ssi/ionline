@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Validar RUT de Solicitud</h3>

<form method="POST" class="form-horizontal" action="{{ route('suitability.validaterun') }}">
    @csrf
    @method('POST')

    <div class="form-row align-items-end">
        <fieldset class="form-group col-5 col-sm-4 col-md-4 col-lg-2">
            <label for="for_run">Run</label>
            <input type="number" class="form-control" id="for_run" name="run" autocomplete="off" max="50000000" required>
        </fieldset>

        <fieldset class="form-group col-2 col-sm-2 col-md-1 col-lg-1">
            <label for="for_dv">DV</label>
            <input type="text" class="form-control" id="for_dv" name="dv" autocomplete="off" readonly>
        </fieldset>
    </div>


    <button type="submit" class="btn btn-primary">Validar</button>


</form>

@endsection

@section('custom_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{ asset('js/jquery.rut.chileno.js') }}"></script>
<script type="text/javascript">
            //obtiene digito verificador
            $('input[name=run]').keyup(function(e) {
                var str = $("#for_run").val();
                $('#for_dv').val($.rut.dv(str));
            });
</script>

@endsection