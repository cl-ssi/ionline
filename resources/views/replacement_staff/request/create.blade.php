@extends('layouts.app')

@section('title', 'Solicitud')

@section('content')

@include('replacement_staff.nav')

<h3 class="mb-3">Formulario Solicitud Contratación de Personal</h3>

<p>Por medio del presente solicita a usted autorizar el llamado a presentar
antecedentes al cargo de:</p>

<form method="POST" class="form-horizontal" action="">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_cargo">Cargo</label>
            <input type="text" class="form-control" name="cargo"
                id="for_cargo" required placeholder="">
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_grado">Grado</label>
            <select name="grado" id="for_grado" class="form-control">
                <option value="">15</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_calidad_juridica">Calidad Jurídica</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                  <label class="form-check-label" for="inlineRadio1">Contrata</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                  <label class="form-check-label" for="inlineRadio2">Honorario</label>
                </div>
            </div>

        </fieldset>

        <fieldset class="form-group col">
            <label for="for_calidad_juridica">La persona cumplirá las labores en Jornada</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                  <label class="form-check-label" for="inlineRadio1">Diurno</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                  <label class="form-check-label" for="inlineRadio2">Tercer Turno</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                  <label class="form-check-label" for="inlineRadio2">Cuarto Turno</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                  <label class="form-check-label" for="inlineRadio2">Otro</label>
                </div>
            </div>

        </fieldset>


    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_desde">Desde</label>
            <input type="date" class="form-control" name="desde"
                id="for_desde" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_Hasta">Hasta</label>
            <input type="date" class="form-control" name="Hasta"
                id="for_Hasta" required placeholder="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_fundamento">Fundamento</label>
            <select name="fundamento" id="for_fundamento" class="form-control">
                <option value="">Reemplazo o suplencia</option>
                <option value="">Renuncia</option>
                <option value="">Permiso sin goce de sueldo</option>
                <option value="">Regulación de cargos</option>
                <option value="">Cargo expansión</option>
                <option value="">Feriado legal</option>
                <option value="">Otros</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_justificacion_otros">Justificación Otros</label>
            <input type="text" class="form-control" name="justificacion_otros"
                id="for_justificacion_otros" required placeholder="">
        </fieldset>

    </div>

        <button type="submit" class="btn btn-primary">Crear</button>

    <p>El documento debe contener las firmas y timbres de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</p>

    JEFATURA SOLICITANTE
    DEL CARGO

    V°B° DIRECCIÓN o SUBDIRECCION
(Según corresponda)


V°B° SUBDIRECCIÓN
RRHH


Correlativo:
Nº
Ítem Presupuestario:
Disposición presupuestaria:
SI   	 NO


VºBº Unidad Gestión de Personal y Ciclo de Vida Laboral
</form>

@endsection

@section('custom_js')

@endsection
