@extends('layouts.bt4.integrity')

@section('title', 'Integridad')

@section('content')

<h2 class="mb-4">Plataforma interna de integridad y código de ética</h2>

<h5>El procedimiento para dar respuesta a su Consulta-Denuncia-Riesgo Ético, consta de las siguientes etapas:</h5>

<ol>
    <li class="text-justify">Etapa de presentación y recepción de la Consulta-Denuncia-Riesgo Ético: conformada por el ingreso o presentación de la solicitud y su recepción por parte del órgano público.</li>
    <li class="text-justify">Etapa de análisis formal de la solicitud: conformada por la verificación de competencia del órgano; revisión de los aspectos formales de la solicitud y eventual subsanación; búsqueda de la información; y, cuando corresponda, determinación, notificación y eventual oposición de los terceros cuyos derechos pudieran verse afectados.</li>
    <li class="text-justify">Etapa de resolución de la solicitud: conformada por la revisión de fondo de la solicitud, la preparación y firma del acto administrativo de respuesta por parte del órgano de la Administración del Estado y su notificación al peticionario.</li>
    <li class="text-justify">Etapa de cumplimiento de lo resuelto: conformada la entrega efectiva de la información y certificación de la misma.</li>

</ol>

<h5>Plazos</h5>

<ul>
    <li class="text-justify">El plazo para dar respuesta a su solicitud es de 20 días hábiles, y excepcionalmente puede ser prorrogado por otros 10 días hábiles, cuando existan circunstancias que hagan difícil reunir la información solicitada, caso en que la Institución requerida comunicará al solicitante, antes del vencimiento del plazo, la prórroga y sus fundamentos.</li>
    <li class="text-justify">El solicitante tiene 15 días hábiles de plazo para acudir al director/a del {{ config('app.ss') }}, en caso de vencer el plazo sin obtener respuesta, o de ser denegada total o parcialmente la petición.</li>
</ul>

<br>

<h4>Ingreso de nueva Consulta/Denuncia/Riesgo Ético</h4>

<form method="POST" class="form-horizontal" action="{{ route('integrity.complaints.store') }}" enctype="multipart/form-data">
    @csrf

    <fieldset class="form-group">
        <label for="for"><strong>Seleccione el tipo*</strong></label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="forConsulta" value="Consulta" {{ old('type') == 'Consulta' ? 'checked' : ''}}  required>
            <label class="form-check-label" for="forConsulta">Consulta</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="forDenuncia" value="Denuncia" {{ old('type') == 'Denuncia' ? 'checked' : ''}} required>
            <label class="form-check-label" for="forDenuncia">Denuncia</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="forRiestoEtico" value="Riesgo ético" {{ old('type') == 'Riesgo ético' ? 'checked' : ''}} required>
            <label class="form-check-label" for="forRiestoEtico">Riesgo ético</label>
        </div>
    </fieldset>

    <fieldset class="form-group">
        <label for="for"><strong>Identifique el valor que más se ve representado con su Consulta/Denuncia/Riesgo Ético*</strong></label><br>
        @foreach($values as $value)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="complaint_values_id" id="for{{ $value->name }}" value="{{ $value->id }}" {{ old('complaint_values_id') == $value->id ? 'checked' : '' }} required>
                <label class="form-check-label" for="for{{ $value->name }}">{{ $value->name }}</label>
            </div>
        @endforeach

        <div class="form-check form-check-inline">
            <input type="text" class="form-control form-control-sm" id="other_value" placeholder="Identificar el otro valor" name="other_value" value="{{ old('other_value') }}">
        </div>

    </fieldset>

    <fieldset class="form-group">
        <label for="for"><strong>Clasifique el Principio de la función pública asociado a su Consulta/Denuncia/Riesgo Ético*</strong></label><br>
        <div class="row">
            @foreach($principles as $principle)
            <div class="col-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="complaint_principles_id" id="for{{ $principle->name }}_p" value="{{ $principle->id }}" {{ old('complaint_principles_id') == $principle->id ? 'checked' : ''}}  required>
                    <label class="form-check-label" for="for{{ $principle->name }}_p">{{ $principle->name }}</label>
                </div>
            </div>
            @endforeach
        </div>
    </fieldset>

    <fieldset class="form-group">
        <label for="forComplaint"><strong>Describa en forma clara y objetiva su Consulta/Denuncia/Riesgo Ético*</strong></label>
        <textarea rows="5" class="form-control" id="forComplaint" name="content" required>{{ old('content') }}</textarea>
    </fieldset>

    <fieldset class="form-group">
        <label for="forFile"><strong>Archivo (opcional)</strong></label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFileLang" name="file" value="{{ old('file') }}">
          <label class="custom-file-label" for="customFileLang">Adjuntar evidencia, puede incluir un archivo zip o rar</label>
        </div>
    </fieldset>

    <fieldset class="form-group">
        <label for="foremail"><strong>Email *</strong></label>
        <input type="email" class="form-control" id="foremail" placeholder="Ingrese su email de respuesta" name="email" value="{{ old('email') }}" required="required" autocomplete="off">
    </fieldset>

    <fieldset class="form-group">
        <label for="for"><strong>¿Conoce el <a target="_blank" href="http://ssiq.redsalud.gob.cl/wrdprss_minsal/wp-content/uploads/2018/06/1-REX-2534_31082017-APRUEBA-CODIGO-DE-ETICA-DEL-SSI.pdf">código de ética</a> de la institución?*</strong></label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="know_code" id="forSi" value="1" {{ old('know_code') == 1 ? 'checked' : ''}} required>
            <label class="form-check-label" for="forSi">Si</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="know_code" id="forNo" value="0" {{ old('know_code') === 0 ? 'checked' : ''}} required>
            <label class="form-check-label" for="forNo">No, declaro formalmente mi desconocimiento del código de ética de la institución.</label>
        </div>

    </fieldset>

    <fieldset class="form-group">
        <label for="for"><strong>¿Desea usted mantener su identitdad en reserva?*</strong><br>
            Sólo será de conocimiento de coordinador de integridad, y sólo podrá ser utilizada para fines estadísticos, sin revelear datos personales o sensibles.</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="identify" id="identifySi" value="1" required>
            <label class="form-check-label" for="identitySi">Si</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="identify" id="identifyNo" value="0" {{ old('identify') == '0' ? 'checked' : ''}} required>
            <label class="form-check-label" for="identityNo">No</label>
        </div>

    </fieldset>

    <fieldset class="form-group" id="fieldrun">
        <label for="forRun">RUN Funcionario</label>
        <input type="number" class="form-control" id="forRun" placeholder="Ingrese RUN sin puntos ni digito verificador ej:16055586" name="user_id" autocomplete="off">
    </fieldset>

    <input type="submit" value="Ingresar" class="btn btn-primary">
</form>

@endsection

@section('custom_js')
<script type="text/javascript">

    $("#other_value").hide();

    $("input[name=complaint_values_id]").click(function() {
        switch(this.value){
            case "8":
                $("#other_value").show("slow");
                break;
            default:
                $("#other_value").hide("slow");
                break;
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        if($("input[name=identify]:checked").val() == "0"){
            $("#fieldrun").show();
        } else {
            $("#fieldrun").hide();
        }

        $("input[name=identify]").click(function() {
            if(this.value == "0"){
                $("#fieldrun").show("slow");
            } else {
                $("#fieldrun").hide("slow");
                document.getElementById("forRun").value = null;
            }
        });
    });
</script>

@endsection
