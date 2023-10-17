@extends('layouts.bt4.app')

@section('title', 'Consultas')

@section('content')

@include('integrity.partials.nav')

<h3>Realizar nueva consulta</h3>

<form method="POST" class="form-horizontal" action="">
    {{ csrf_field() }}
    <fieldset disabled>
        <fieldset class="form-group">
            <label for="forUser">Funcionario</label>
            <input type="text" readonly class="form-control" id="forUser" value="Alvaro Torres Fuchslocher">
        </fieldset>
    </fieldset>

    <fieldset class="form-group">
        <label for="foremail">Email *</label>
        <input type="text" class="form-control" id="foremail" placeholder="Ingrese su email para la respuesta" name="email" required="required">
    </fieldset>

    <fieldset class="form-group">
        <label for="forComplaint">Contenido de la consulta</label>
        <textarea rows="5" class="form-control" id="forComplaint" placeholder="" name="complaint" required=""></textarea>
    </fieldset>

     <button type="submit" class="btn btn-primary">Ingresar</button>
</form>


<br> <hr>


<h3>Uso interno</h3>

<fieldset class="form-group">
    <label for="for">¿Consulta es de tema jurídico?</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions1" id="inlineRadio1" value="option1" onchange="deshabilitar(this.checked);">
        <label class="form-check-label" for="inlineRadio1">Si</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions1" id="inlineRadio2" value="option2" onchange="habilitar(this.checked);">
        <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
</fieldset>

<fieldset class="form-group">
    <label for="for">¿Corresponde a conflicto o inobservancia de normas éticas definidas?</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions2" id="inlineRadio3" value="option1" disabled>
        <label class="form-check-label" for="inlineRadio1">Si</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions2" id="inlineRadio4" value="option2" disabled>
        <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
</fieldset>

<fieldset class="form-group">
    <label for="forComplaint">Respuesta</label>
    <textarea rows="5" class="form-control" id="forComplaint" placeholder="" name="complaint" required=""></textarea>
</fieldset>

<button type="submit" class="btn btn-primary">Guardar</button>
<button type="submit" class="btn btn-default"><i class="fas fa-paper-plane"></i> Enviar</button>

<script>
    function habilitar(value)
    {
        document.getElementById("inlineRadio3").disabled=false;
        document.getElementById("inlineRadio4").disabled=false;
    }
    function deshabilitar(value)
    {
        document.getElementById("inlineRadio3").disabled=true;
        document.getElementById("inlineRadio3").checked=false;
        document.getElementById("inlineRadio4").disabled=true;
        document.getElementById("inlineRadio4").checked=false;
    }
</script>

@endsection
