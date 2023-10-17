@extends('layouts.bt4.app')

@section('title', 'Nuevo item de Emergencias y desastres '.$programming->establishment->type.' '.$programming->establishment->name.' '.$programming->year)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Nuevo item de Emergencias y desastres {{ $programming->establishment->type }} {{ $programming->establishment->name }} {{ $programming->year}} </h3>
<br>

<form method="POST" class="form-horizontal" action="{{ route('emergencies.store', $programming) }}">
    @csrf
    @method('POST')
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="forprogram">Origen</label>
            <select name="origin" id="for_origin" class="form-control" required>
                <option value="">Seleccione opción</option>
                <option value="Natural">Natural</option>
                <option value="Antrópico">Antrópico (Humano)</option>
            </select>
        </div>
        <div class="form-group col-md-10">
            <label for="forprogram">Peligro / Amenaza</label>
            <select name="name" id="for_name" class="form-control" required>
                <option value="">Seleccione opción</option>
            </select>
        </div>
    </div>
    <div id="div_for_another_name" class="form-row" style="display: none">
        <div class="form-group col-md-12">
            <fieldset class="form-group">
                <label for="for_another_name">Nombre del peligro / amenaza</label>
                <input type="text" class="form-control" id="for_another_name" name="another_name" value="{{old('another_name')}}">
            </fieldset>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <fieldset class="form-group">
                <label for="for_frecuency">Frecuencia / Ocurrencia</label>
                <a tabindex="0" id="popover-frecuency-natural"  role="button" data-toggle="popover" data-trigger="focus" data-html="true" style="display: none"
                title="Frecuencia de ocurrencia (a)" 
                data-content="Para el caso de las amenazas de Origen Natural, se deben considerar los siguientes criterios:<br>
                3 => Menos de 5 años <br>
                2 => Entre 5 y 10 años <br>
                1 => Más de 10 años">
                <i class="fas fa-info-circle"></i></a>
                <a tabindex="0"  id="popover-frecuency-antropico" role="button" data-toggle="popover" data-trigger="focus" data-html="true" style="display: none"
                title="Frecuencia de ocurrencia (a)" 
                data-content="Para el caso de las amenazas de Origen Antrópico, se deben considerar los siguientes criterios:<br>
                3 => Ocurrencia de 10  o más eventos durante un año.<br>
                2 => Ocurrencia entre 5 y 10 eventos durante un año.<br>
                1 => Ocurrencia inferior o igual a 5 eventos durante un año.">
                <i class="fas fa-info-circle"></i></a>
                <input type="number" min="1" max="3" class="form-control" id="for_frecuency" name="frecuency" value="{{old('frecuency')}}" required>
            </fieldset>
        </div>
        <div class="form-group col-md-3">
            <fieldset class="form-group">
                <label for="for_impact_level">Nivel de impacto</label>
                <a tabindex="0"  id="popover-impact-level-natural" role="button" data-toggle="popover" data-trigger="focus" data-html="true" style="display: none"
                title="Nivel de Impacto (b)" 
                data-content="Para el caso de las amenazas de Origen Natural, se deben considerar los siguientes criterios:<br>
                3 => Suspensión permanente de Suministros Básicos,
                     Daño Estructural de Establecimientos de Salud,
                     Víctimas Fatales, Heridos y damnificados,
                     Interrupción permanente de Comunicaciones (Terrestre, Telefonía, Internet, etc),
                     Requerimiento de Ambulancias superado (sin capacidad de brindar cobertura),
                     (Este evento tiene la categoría de DESASTRE, definido como aquel que es capaz de superar la capacidad de respuesta de la institucionalidad).<br>
                2 => Suspensión intermitente de Suministros Básicos,
                     Víctimas Fatales o Heridos o damnificados,
                     Algún tipo de daño en servicio de Comunicaciones (Terrestre o Telefónica o Internet),
                     Requerimiento de Ambulancias con dificultad.<br>
                1 => Heridos, Dificultades en las comunicaciones. Produce Conmoción Pública, puede ser atendido y resuelto por los equipos locales.">
                <i class="fas fa-info-circle"></i></a>
                <a tabindex="0"  id="popover-impact-level-antropico" role="button" data-toggle="popover" data-trigger="focus" data-html="true" style="display: none"
                title="Nivel de Impacto (b)" 
                data-content="Para el caso de las amenazas de Origen Antrópico, se deben considerar los siguientes criterios:<br>
                3 => Deterioro importante del medio ambiente. Víctimas fatales, heridos, evacuados y damnificados, requerimientos de ambulancia superado (sin capacidad de brindar cobertura) (Este evento tiene la categoría de desastre, definido como aquel que es capaz de superar la capacidad de respuesta de la institución.)<br>
                2 => Genera corte de suministros básicos, daño menor a infraestructura y produce heridos, evacuados o damnificados.<br>
                1 => Produce sólo conmoción  pública, puede ser atendido y resuelto por los equipos locales.">
                <i class="fas fa-info-circle"></i></a>
                <input type="number" min="1" max="3" class="form-control" id="for_impact_level" name="impact_level" value="{{old('impact_level')}}" required>
            </fieldset>
        </div>
        <div class="form-group col-md-3">
            <fieldset class="form-group">
                <label for="for_ss_rol">Rol del Servicio Salud</label>
                <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" data-html="true"
                title="Rol del Servicio de Salud (c)" 
                data-content="Para ambos eventos (de origen natural y antrópico), se debe medir el “Rol del Servicio de Salud o Salud Comunal para enfrentar un evento adverso”.<br>
                3 => SSI o Salud Comunal, con su red de establecimientos presenta un rol activo en la emergencia o desastres Ejemplo: caso de accidentes de tránsito de múltiples víctimas.<br>
                2 => SSI o salud comunal, permanece en estado de alerta o con poca participación, ejemplo: emergencia química.<br>
                1 => SSI o salud Comunal tiene escasa o nula participación. Ejemplo incendio  forestal">
                <i class="fas fa-info-circle"></i></a>
                <input type="number" min="1" max="3" class="form-control" id="for_ss_rol" name="ss_rol" value="{{old('ss_rol')}}" required>
            </fieldset>
        </div>
        <div class="form-group col-md-3">
            <fieldset class="form-group">
                <label for="for_factor">Factor</label>
                <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
                title="Factor" 
                data-content="Factor de multiplicación de c/u de los tres factores anteriores (a*b*c)">
                <i class="fas fa-info-circle"></i></a>
                <input type="number" class="form-control" id="for_factor" name="value" value="{{old('factor')}}" disabled>
            </fieldset>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="for_description">Descripción de los posibles efectos</label>
            <textarea class="form-control" id="for_description" name="description" rows="5" required></textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="for_measures">Medidas de Prevención y Mitigación gestionadas para los posibles efectos</label>
            <textarea class="form-control" id="for_measures" name="measures" rows="5" required></textarea>
        </div>
    </div>


    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">Volver</a>

</form>

@endsection

@section('custom_js')

<script type="text/javascript">
$(function () {
    $('[data-toggle="popover"]').popover()
})
$('.popover-dismiss').popover({
    trigger: 'focus'
}) 

$('#for_frecuency,#for_impact_level,#for_ss_rol').keyup(function() {
    var factor = $('#for_frecuency').val() * $('#for_impact_level').val() * $('#for_ss_rol').val();
    $('#for_factor').val(Math.round(factor));
});

$('#for_origin').change(function() {
    var categories = @json($categories);
    $('#for_name').find('option:not(:first)').remove();
    if($(this).find('option:selected').val() != '')
        categories[$(this).find('option:selected').val()].forEach(function(category){
            $('#for_name').append($("<option></option>").attr("value",category).text(category));
        })
    $('#for_name').change();

    if($('#for_origin').val() == 'Natural'){
        $('#popover-frecuency-natural,#popover-impact-level-natural').show();
        $('#popover-frecuency-antropico,#popover-impact-level-antropico').hide();
    }else if($('#for_origin').val() == 'Antrópico'){
        $('#popover-frecuency-natural,#popover-impact-level-natural').hide();
        $('#popover-frecuency-antropico,#popover-impact-level-antropico').show();
    }else{
        $('#popover-frecuency-natural,#popover-frecuency-antropico,#popover-impact-level-natural,#popover-impact-level-antropico').hide();
    }
});

$('#for_name').change(function() {
    if($(this).find('option:selected').val() == 'OTRO'){
        $('#for_another_name').prop('required', true);
        $('#div_for_another_name').show();
    }else{
        $('#for_another_name').prop('required', false).val('');
        $('#div_for_another_name').hide();
    }
});

</script>

@endsection