@extends('layouts.bt4.app')

@section('title', 'Item Programación')

@section('content')

@include('programmings/nav')



<h4 class="mb-3">
    <a href="{{ Session::has('items_url') ? Session::get('items_url') : url()->previous() }}" class="btn btb-flat btn-sm btn-dark" >
                    <i class="fas fa-arrow-left small"></i> 
                    <span class="small">Volver</span> 
    </a>
Nuevo Item Programación Operativa </h4>



@if(!Request::get('activity_type') || Request::get('activity_type') == 'Directa')
<form method="GET" class="form-horizontal small" action="{{ route('programmingitems.create') }}" enctype="multipart/form-data">

    <input type="hidden" class="form-control" id="forreferente" name="programming_id" value="{{Request::get('programming_id')}}">

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="forprogram">Buscar</label>
            <select style="font-size:70%;" name="activity_search_id" id="activity_search_id" class="form-control selectpicker" data-live-search="true" data-style="btn-info" required>
                     <option style="font-size:70%;">
                    </option>
                @foreach($activityItems as $activityItem)
               
                    <option style="font-size:70%;" value="{{ $activityItem->id}}">
                        {{ $activityItem->tracer }} - 
                        {{ $activityItem->activity_name }} - 
                        {{ $activityItem->def_target_population }} - 
                        {{ $activityItem->professional }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

</form>
<hr>
<form method="POST" class="form-horizontal small" action="{{ route('programmingitems.store') }}" enctype="multipart/form-data">
@csrf   
    <input type="hidden" class="form-control" id="programming_id" name="programming_id" value="{{Request::get('programming_id')}}">
    <input type="hidden" class="form-control" id="activity_type" name="activity_type" value="Directa">
    <input type="hidden" class="form-control" id="active" name="active" value="SI">
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="forprogram">Tipo Actividad</label>
            <select name="activity_type" id="activity_type"  class="form-control" disabled>
                    <option value="Directa">Directa</option>
                    <option value="Indirecta">Indirecta</option>
                
            </select>
        </div>
        <div class="form-group col-md-1">
            <label for="forprogram">Taller</label>
            <select name="workshop" id="workshop" onchange="yesnoCheck(this);" class="form-control">
                    <option value="NO">NO</option>
                    <option value="SI">SI</option>
                
            </select>
        </div>
        
        <div class="form-group col-md-4">
            <label for="forprogram">Ciclo Vital</label>
            @php($cycleList = ['INFANTIL', 'ADOLESCENTE', 'ADULTO', 'ADULTO MAYOR', 'TRANSVERSAL'])
            <select name="cycle" id="cycle" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($cycleList as $cycle)
                <option value="{{$cycle}}" {{ $activityItemsSelect && $activityItemsSelect->vital_cycle == $cycle ? 'selected' : '' }}>{{$cycle}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-5">
            <label for="forprogram">Acción</label>
            @php($actionList = ['Prevención', 'Diagnóstico', 'Tratamiento', 'Promoción'])
            <select name="action_type" id="action_type" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($actionList as $action)
                <option value="{{$action}}" {{ $activityItemsSelect && $activityItemsSelect->action_type == $action ? 'selected' : '' }}>{{$action}}</option>
                @endforeach        
            </select>
        </div>
        {{--@else
        <div class="form-group col-md-4">
            <label for="forprogram">Ciclo Vital</label>
            <input type="input" class="form-control" id="cycle" name="cycle" value="{{ $activityItemsSelect ? $activityItemsSelect->vital_cycle : '' }}" required="" readonly>
        </div>
        <div class="form-group col-md-5">
            <label for="forprogram">Acción</label>
            <input type="input" class="form-control" id="action_type" name="action_type" value="{{ $activityItemsSelect ? $activityItemsSelect->action_type : '' }}" required="" readonly>
        </div>
        @endif--}}
    </div>

    <div class="form-row">

        <div class="form-group col-md-1">
            <label for="forprogram">Trazadora</label>
            <input type="input" class="form-control" id="tracer" name="tracer" value="{{ $activityItemsSelect ? $activityItemsSelect->tracer : '' }}" required="" readonly>
        </div>
    
        <div class="form-group col-md-11">
            <label for="forprogram">Actividad o Prestación</label>
            <input type="input" class="form-control" id="activity_name" name="activity_name" value="{{ $activityItemsSelect ? $activityItemsSelect->activity_name : '' }}" required="" readonly>
        </div>
        <input type="hidden" class="form-control" id="activity_id" name="activity_id" value="{{ $activityItemsSelect ? $activityItemsSelect->id : '' }}" required="">
    </div>

    <div class="form-row">
    
        <div class="form-group col-md-8">
            <label for="forprogram">Def. Población Objetivo</label>
            <input type="input" class="form-control" id="forreferente" name="def_target_population" value="{{ $activityItemsSelect ? $activityItemsSelect->def_target_population : '' }}" required>
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Fuente Población</label>
            <input type="input" class="form-control " id="forreferente" name="source_population" value="" required="">
            <small>Ej. Fonasa - Tarjetero Electrónico</small>
        </div>
    </div>

    <div class="form-row">
    

        <div class="form-group col-md-2">
            <label for="forprogram">Nº Población Objetivo</label> 
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Población Objetivo" 
            data-content="Expresar numéricamente la cantidad de población Ej: 15000">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" class="form-control " id="cant_target_population" name="cant_target_population"  required="">
        </div>
        <div class="form-group col-md-2">
            <label for="forprogram">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="prevalence_option" id="prevalence_option">
                <label class="form-check-label" for="prevalence_option">
                Prevalencia o Tasa (%)
                </label>
            </div>
            </label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Prevalencia o Tasa (%)" 
            data-content="Utilizar este dato cuando se desconoce el número de usuarios con el fin de estimar una población que podría percibir en el año a programar Ej: 50%">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control" id="prevalence_rate" name="prevalence_rate" disabled>
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Fuente Prevalencia o Tasa</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Fuente Prevalencia o Tasa" 
            data-content="En caso de utilizar prevalencia/tasa, se debe indicar la fuente del dato Ej: Minsal">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="source_prevalence" name="source_prevalence" >
            <small></small>
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Cobertura (%)</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Cobertura (%)" 
            data-content="Es el porcentaje de la población que se va a atender. Se expresa en porcentaje. Las prestaciones universales se deben consignar por sobre un 90% de cobertura Ej: 43%">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control" id="coverture" name="coverture" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Nº Población a Atender</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Población a Atender" 
            data-content="Es el cálculo matemático de una actividad ponderada: multiplicación de la población por su incidencia/prevalencia y por la cobertura.">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" class="form-control" id="population_attend" name="population_attend" required="" readonly>
        </div>
        
    </div>

    <div class="form-row">

        <div class="form-group col-md-2">
            <label for="forprogram">Concentración</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Concentración" 
            data-content="La cantidad de veces que debo darle el control anual">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" class="form-control" id="concentration" name="concentration" required="">
        </div>

        <div class="form-group col-md-2" id="ifYes_activity_group" style="display: none;">
            <label for="forprogram">N° De Personas por Grupo</label>
            <input type="number" class="form-control" id="activity_group" name="activity_group" >
        </div>

        <div class="form-group col-md-2" id="ifYes_workshop_number" style="display: none;">
            <label for="forprogram">N° De Talleres</label>
            <input type="number" class="form-control" id="workshop_number" name="workshop_number"  readonly>
        </div>

        <div class="form-group col-md-2" id="ifYes_workshop_session_number" style="display: none;">
            <label for="forprogram">N° De Sesión por Talleres</label>
            <input type="number" class="form-control" id="workshop_session_number" name="workshop_session_number" > 
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Total Actividad</label>
            <input type="input" class="form-control" id="activity_total" name="activity_total" value="" required="" readonly>
        </div>

    </div>
    @if($year >= 2023)
    <!-- hidden dynamic element to clone -->
    <div class="form-group dynamic-element" style="display:none">
    <hr>
    <div class="form-row">
    
        <div class="form-group col-md-6">
            <label for="forprogram">Profesional/Funcionario <span class="text-danger">{{ $activityItemsSelect ? '- Rec. '.$activityItemsSelect->professional : '' }}</span></label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Profesional/Funcionario" 
            data-content="Funcionario que otorga la prestación, Si es más de un funcionario para la actividad programada se debe repetir en otro registro">
            <i class="fas fa-info-circle"></i></a>
            <select name="professionals[0][professional_hour_id]" id="formprogram" class="form-control">
                @foreach($professionalHours as $professionalHour)
                    <option value="{{ $professionalHour->id }}">{{ $professionalHour->professional->alias ?? '' }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Rendimiento de la Actividad</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Rendimiento de la Actividad" 
            data-content="Número de veces que se realiza un tipo de actividad durante una hora cronológica por parte de un funcionario 
            (EJ: Rendimiento de 45 minutos es 60/45=1.3).
             Cuando el rendimiento está normado debe utilizarse el estandar de la norma o uno menor según acuerdo local.">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control calculate-performance" id="activity_performance" name="professionals[0][activity_performance]" >
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Total Día Habiles</label>
            <input type="number" class="form-control" id="habil_days" value="{{ $programmingDays ? $programmingDays->days_programming : '' }}" name="professionals[0][habil_days]" readonly>
        </div>

        <div class="form-group col-md-1">
            <label for="forprogram">Hora Laboral</label>
            <input type="number" class="form-control" id="work_valid_hour_day" value="{{ $programmingDays ? $programmingDays->day_work_hours : '' }}" name="professionals[0][work_valid_hour_day]" readonly>
        </div>
        
    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            <label for="forprogram">Horas Años Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas Años Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_year" name="professionals[0][hours_required_year]" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Horas días Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas días Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en un dia del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_day" name="professionals[0][hours_required_day]" readonly>
        </div>
    
        <div class="form-group col-md-s">
            <label for="forprogram">Jornadas Directas Año</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Directas Año" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_year" name="professionals[0][direct_work_year]" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Jornadas Horas Directas Diarias</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Horas Directas Diarias" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en un día del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_hour" name="professionals[0][direct_work_hour]" readonly>
        </div>
    </div>
    </div>
    <!-- end hidden dynamic element to clone -->
    <div class="dynamic-stuff"></div>
    <button type="button" class="btn btn-link mx-auto d-block add-one">+ Añadir otro profesional</button>
    <hr>
    @else

    <div class="form-row">
    
        <div class="form-group col-md-6">
            <label for="forprogram">Profesional/Funcionario <span class="text-danger">{{ $activityItemsSelect ? '- Rec. '.$activityItemsSelect->professional : '' }}</span></label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Profesional/Funcionario" 
            data-content="Funcionario que otorga la prestación, Si es más de un funcionario para la actividad programada se debe repetir en otro registro">
            <i class="fas fa-info-circle"></i></a>
            <select name="professional" id="formprogram" class="form-control">
                @foreach($professionalHours as $professionalHour)
                    <option value="{{ $professionalHour->id }}">{{ $professionalHour->professional->alias ?? '' }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Rendimiento de la Actividad</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Rendimiento de la Actividad" 
            data-content="Número de veces que se realiza un tipo de actividad durante una hora cronológica por parte de un funcionario 
            (EJ: Rendimiento de 45 minutos es 60/45=1.3).
             Cuando el rendimiento está normado debe utilizarse el estandar de la norma o uno menor según acuerdo local.">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control" id="activity_performance" name="activity_performance" required="" >
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Total Día Habiles</label>
            <input type="number" class="form-control" id="habil_days" value="{{ $programmingDays ? $programmingDays->days_programming : '' }}" name="habil_days" required="" readonly>
        </div>

        <div class="form-group col-md-1">
            <label for="forprogram">Hora Laboral</label>
            <input type="number" class="form-control" id="work_valid_hour_day" value="{{ $programmingDays ? $programmingDays->day_work_hours : '' }}" name="work_valid_hour_day" required="" readonly>
        </div>
        
    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            <label for="forprogram">Horas Años Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas Años Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_year" name="hours_required_year" required="" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Horas días Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas días Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en un dia del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_day" name="hours_required_day" required="" readonly>
        </div>
    
        <div class="form-group col-md-s">
            <label for="forprogram">Jornadas Directas Año</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Directas Año" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_year" name="direct_work_year" required="" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Jornadas Horas Directas Diarias</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Horas Directas Diarias" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en un día del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_hour" name="direct_work_hour" required="" readonly>
        </div>
    </div>
    
    @endif
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="forprogram">Fuente Información</label>
            <input type="input" class="form-control" id="information_source" value="{{ $activityItemsSelect ? $activityItemsSelect->verification_rem : '' }}" name="information_source">
        </div>
        <div class="form-group col-md-3">
            <label for="forprogram">Financiada por Prap</label>
            <select name="prap_financed" id="prap_financed" class="form-control">
                    <option value="NO">No</option>
                    <option value="SI">SI</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="forprogram">Observación</label>
            <input type="input" class="form-control" id="observation" name="observation" >
        </div>    
    </div>
    <button id="activity_submit" type="submit" class="btn btn-info mb-4">Crear</button>

</form>
@else
<!-- Actividad indirecta esporadica o por designación -->
<form method="POST" class="form-horizontal small" action="{{ route('programmingitems.store') }}">
@csrf   
    <input type="hidden" class="form-control" id="programming_id" name="programming_id" value="{{Request::get('programming_id')}}">
    <input type="hidden" class="form-control" id="activity_type" name="activity_type" value="Indirecta">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="forprogram">Subtipo de actividad indirecta</label>
            <select name="activity_subtype" id="activity_subtype"  class="form-control" required>
                <option value="Esporádicas">Actividades Esporádicas</option>
                <option value="Designación">Designación de horas funcionarios por rol</option>
            </select>
        </div>
        <div class="form-group col-md-3" id="activity_category_div">
            <label for="forprogram">Categoría</label>
            <select name="activity_category" id="activity_category" class="form-control" required>
                <option value="">Seleccione opción</option>
                <option value="Reunión">Reunión</option>
                <option value="Jornada">Jornada</option>
                <option value="Consultoría">Consultoría</option>
                <option value="Supervisión Interna">Supervisión Interna</option>
                <option value="Plan de Intervención (N° familias)">Plan de Intervención (N° familias)</option>
                <option value="Trabajo administrativo">Trabajo administrativo</option>
                <option value="Viaje de ronda">Viaje de ronda</option>
                <option value="Tele interconsulta">Tele interconsulta</option>
                <option value="Tele consultoría">Tele consultoría</option>
            </select>
        </div>
        <div class="form-group col-md-3" id="work_area_div" style="display: none">
            <label for="forprogram">Área de trabajo</label>
            <select name="work_area" id="work_area" class="form-control">
                <option value="">Seleccione opción</option>
                <option value="Dirección">Dirección</option>
                <option value="SOME">SOME</option>
                <option value="Esterilización">Esterilización</option>
                <option value="Interconsulta">Interconsulta</option>
                <option value="Epidemiología">Epidemiología</option>
                <option value="SIGGES">SIGGES</option>
                <option value="OIRS">OIRS</option>
                <option value="Informática">Informática</option>
                <option value="Estadísticas">Estadísticas</option>
                <option value="Sala de Tratamiento">Sala de Tratamiento</option>
                <option value="Farmacia">Farmacia</option>
                <option value="Bodega de Leche">Bodega de Leche</option>
                <option value="Dental">Dental</option>
                <option value="Referencia de programa">Referencia de programa</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
        <div class="form-group col-md-6" id="activity_name_div">
            <label for="forprogram">Nombre de la actividad</label>
            <input type="input" class="form-control" id="activity_name" name="activity_name" required>
        </div>
        <div class="form-group col-md-3" id="another_work_area_div" style="display: none">
            <label for="forprogram">Otro, ¿Cúal?</label>
            <input type="input" class="form-control" id="another_work_area" name="another_work_area" readonly>
        </div>
        <div class="form-group col-md-3" id="work_area_specs_div" style="display: none">
            <label for="forprogram">Especificaciones área de trabajo</label>
            <input type="input" class="form-control" id="work_area_specs" name="work_area_specs">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2" id="times_month_div">
            <label for="forprogram">N° veces al mes</label>
            <input type="number" class="form-control" id="times_month" name="times_month" required>
        </div>
        <div class="form-group col-md-2" id="months_year_div">
            <label for="forprogram">N° meses del año</label>
            <input type="number" class="form-control" id="months_year" name="months_year" required>
        </div>
        <div class="form-group col-md-2" id="activity_total_div">
            <label for="forprogram">Total Actividad</label>
            <input type="input" class="form-control" id="activity_total" name="activity_total" value="" required="" readonly>
        </div>
    </div>
    <!-- hidden dynamic element to clone -->
    <div class="form-group dynamic-element" style="display:none">
    <hr>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="forprogram">Profesional/Funcionario</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Profesional/Funcionario" 
            data-content="Funcionario que otorga la prestación, Si es más de un funcionario para la actividad programada se debe repetir en otro registro">
            <i class="fas fa-info-circle"></i></a>
            <select name="professionals[0][professional_hour_id]" id="formprogram" class="form-control">
                @foreach($professionalHours as $professionalHour)
                    <option value="{{ $professionalHour->id }}">{{ $professionalHour->professional->alias ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3" id="activity_performance_div">
            <label for="forprogram">Rendimiento de la Actividad</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Rendimiento de la Actividad" 
            data-content="Número de veces que se realiza un tipo de actividad durante una hora cronológica por parte de un funcionario 
            (EJ: Rendimiento de 45 minutos es 60/45=1.3).
             Cuando el rendimiento está normado debe utilizarse el estandar de la norma o uno menor según acuerdo local.">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control calculate-performance" id="activity_performance" name="professionals[0][activity_performance]" >
        </div>
        <div class="form-group col-md-3" id="designated_hours_weeks_div" style="display: none">
            <label for="forprogram">Horas/semanas designadas</label>
            <input type="number" setp="any" class="form-control calculate-designated" id="designated_hours_weeks" name="professionals[0][designated_hours_weeks]">
        </div>
        <div class="form-group col-md-2">
            <label for="forprogram">Total Día Habiles</label>
            <input type="number" class="form-control" id="habil_days" value="{{ $programmingDays ? $programmingDays->days_programming : '' }}" name="professionals[0][habil_days]" readonly>
        </div>
        <div class="form-group col-md-1">
            <label for="forprogram">Hora Laboral</label>
            <input type="number" class="form-control" id="work_valid_hour_day" value="{{ $programmingDays ? $programmingDays->day_work_hours : '' }}" name="professionals[0][work_valid_hour_day]" readonly>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="forprogram">Horas Años Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas Años Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_year" name="professionals[0][hours_required_year]" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="forprogram">Horas días Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas días Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en un dia del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_day" name="professionals[0][hours_required_day]" readonly>
        </div>
        <div class="form-group col-md-s">
            <label for="forprogram">Jornadas Directas Año</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Directas Año" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_year" name="professionals[0][direct_work_year]" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="forprogram">Jornadas Horas Directas Diarias</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Horas Directas Diarias" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en un día del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_hour" name="professionals[0][direct_work_hour]" readonly>
        </div>
    </div>
    </div>
    <!-- end hidden dynamic element to clone -->
    <div class="dynamic-stuff"></div>
    <button type="button" class="btn btn-link mx-auto d-block add-one">+ Añadir otro profesional</button>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="forprogram">Fuente Información</label>
            <input type="input" class="form-control" id="information_source" value="{{ $activityItemsSelect ? $activityItemsSelect->verification_rem : '' }}" name="information_source">
        </div>
        <div class="form-group col-md-3">
            <label for="forprogram">Financiada por Prap</label>
            <select name="prap_financed" id="prap_financed" class="form-control">
                    <option value="NO">No</option>
                    <option value="SI">SI</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="forprogram">Observación</label>
            <input type="input" class="form-control" id="observation" name="observation" >
        </div>    
    </div>
    <button type="submit" class="btn btn-info mb-4">Crear</button>
</form>
@endif

@endsection

@section('custom_js')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script>
    function yesnoCheck(that) {
        if (that.value == "SI") {
   // alert("check");
            document.getElementById("ifYes_activity_group").style.display = "block";
            document.getElementById("ifYes_workshop_number").style.display = "block";
            document.getElementById("ifYes_workshop_session_number").style.display = "block";

            document.getElementById("ifYes_workshop_number").readonly = true;
            document.getElementById("concentration").disabled = true;
            document.getElementById("prevalence_rate").disabled = true;
            document.getElementById("source_prevalence").disabled = true;
            document.getElementById("workshop_session_number").required = true;
            document.getElementById("workshop_number").required = true;
            document.getElementById("activity_group").required = true;
            
        } else {
            document.getElementById("ifYes_activity_group").style.display = "none";
            document.getElementById("ifYes_workshop_number").style.display = "none";
            document.getElementById("ifYes_workshop_session_number").style.display = "none";
            document.getElementById("workshop_session_number").required = false;
            document.getElementById("workshop_number").required = false;
            document.getElementById("activity_group").required = false;
            document.getElementById("prevalence_rate").disabled = false;
            document.getElementById("source_prevalence").disabled = false;
            document.getElementById("concentration").disabled = false;
        }
    }

    $('#activity_subtype').change(function() {
        if($(this).find('option:selected').val() == 'Designación'){
            $('#work_area_div,#another_work_area_div,#designated_hours_weeks_div,#work_area_specs_div').show();
            $('#work_area').prop('required', true);
            $('#activity_category_div,#activity_name_div,#times_month_div,#months_year_div,#activity_total_div,#activity_performance_div').hide();
            $('#activity_category,#activity_name,#times_month,#months_year,#activity_total,#activity_performance').prop('required', false).val('');
        }else{
            $('#work_area_div,#another_work_area_div,#designated_hours_weeks_div,#work_area_specs_div').hide();
            $('#work_area,#another_work_area,#designated_hours_weeks,#work_area_specs').prop('required', false).val('');
            $('#activity_category_div,#activity_name_div,#times_month_div,#months_year_div,#activity_total_div,#activity_performance_div').show();
            $('#activity_category,#activity_name,#times_month,#months_year,#activity_total,#activity_performance').prop('required', true);
        }
    });

    $('#work_area').change(function() {
        if($(this).find('option:selected').val() == 'Otro'){
            $('#another_work_area').prop('required', true).prop('readonly', false);
        }else{
            $('#another_work_area').prop('required', false).prop('readonly', true).val('');
        }
    });

    $('#times_month,#months_year').keyup(function() {
        var calc = $('#times_month').val() * $('#months_year').val();
        $('#activity_total').val(Math.round(calc));
        $('.calculate-performance').keyup();
    });

    $(function () {
        $('[data-toggle="popover"]').popover()
    })
    $('.popover-dismiss').popover({
        trigger: 'focus'
    }) 

    $('#activity_search_id').change(function() {
        this.form.submit();
    });

    $('#prevalence_option').click(function() {
        var result = $('#prevalence_option').is(":checked");
        $("#prevalence_rate").prop('disabled', !result);
        $("#prevalence_rate").prop('required', result);
        $("#prevalence_rate").val('').keyup();
    });


    $('#prevalence_rate, #cant_target_population, #coverture').keyup(function() {

        var prevalence_rate = $('#prevalence_rate').val() ? $('#prevalence_rate').val() : 100;
        var coverture       = $('#coverture').val() ? $('#coverture').val() : 100;

        var calc = $('#cant_target_population').val() * (prevalence_rate/100) * (coverture/100);

        $('#population_attend').val(Math.round(calc));
        $('#concentration,#workshop_session_number,#activity_group,#activity_total').keyup();
    });

    $('#activity_group').keyup(function() {
        
        var activity_group          = $('#activity_group').val();
        var population_attend   = $('#population_attend').val();

        if(activity_group == 0)
        {
            var workshop_number_res = activity_group;
            console.log("concentration == 0");
        }

        else if(activity_group > 0)
        {
            var workshop_number_res = $('#population_attend').val()/activity_group;
            console.log("concentration > 0");
            
        }

        $('#workshop_number').val(Math.round(workshop_number_res));
        $('#activity_total,#workshop_session_number').keyup();
        $('.calculate-performance').keyup();
    });

    $('#workshop_session_number').keyup(function() {
        
        var workshop_number          = $('#workshop_number').val();
        var activity_group   = $('#activity_group').val();
        var workshop_session_number   = $('#workshop_session_number').val();
        

        if(workshop_session_number == 0)
        {
            var activity_total_res = workshop_number;
            console.log("concentration == 0");
        }

        else if(workshop_session_number > 0)
        {
            var activity_total_res = workshop_number*workshop_session_number;
            console.log("concentration > 0");
            
        }

        $('#activity_total').val(Math.round(activity_total_res));
        $('#activity_total').keyup();
        $('.calculate-performance').keyup();
    });

    $('#concentration').keyup(function() {
        
        var concentration = $('#concentration').val() ? $('#concentration').val() : 1;

        var calc = $('#population_attend').val() * concentration;
        $('#activity_total').val(Math.round(calc));
        $('#activity_performance,#activity_total').keyup();
        $('.calculate-performance').keyup();
    });

    $('#activity_performance').keyup(function() {
        
        var activity_total = $('#activity_total').val();
        var activity_performance = $('#activity_performance').val();
        var habil_days = $('#habil_days').val();
        var work_valid_hour_day = $('#work_valid_hour_day').val();
        
        

        if(activity_total == 0 || activity_performance == 0)
        {
            var hours_required_year = '';
            var hours_required_day = '';
            var direct_work_year = '';
            var direct_work_hour = '';
        }
        
        else if(activity_total > 0)
        {
            var hours_required_year = $('#activity_total').val() / activity_performance;
            var hours_required_day  = $('#activity_total').val() / activity_performance / habil_days;
            var direct_work_year    = hours_required_day/ work_valid_hour_day ;
            var direct_work_hour    =  direct_work_year/work_valid_hour_day;
            
            console.log("concentration > 0");
            
        }
        else {
            var hours_required_year = $('#activity_total').val() / activity_performance;
            var hours_required_day  = $('#activity_total').val() / activity_performance;
            var direct_work_year    = $('#activity_total').val() / activity_performance;
            var direct_work_hour    = $('#activity_total').val() / activity_performance;
            console.log("ELSE");
            
        }
    
        $('#hours_required_year').val(Math.round(hours_required_year));
        $('#hours_required_day').val(hours_required_day.toFixed(2));
        $('#direct_work_year').val(direct_work_year.toFixed(5));
        $('#direct_work_hour').val(direct_work_hour.toFixed(5));
        
    });

    $(document).on('keyup', '.calculate-performance', function() {

        var div = $(this).closest('.dynamic-element');
        var activity_performance = div.find('#activity_performance').val();
        var activity_total = $('#activity_total').val();
        var habil_days = div.find('#habil_days').val();
        var work_valid_hour_day = div.find('#work_valid_hour_day').val();        

        if(activity_total == 0 || activity_performance == 0)
        {
            div.find('#hours_required_year').val('');
            div.find('#hours_required_day').val('');
            div.find('#direct_work_year').val('');
            div.find('#direct_work_hour').val('');
            return;
        }
        
        else if(activity_total > 0)
        {
            var hours_required_year = activity_total / activity_performance;
            var hours_required_day  = activity_total / activity_performance / habil_days;
            var direct_work_year    = hours_required_day/ work_valid_hour_day ;
            var direct_work_hour    =  direct_work_year/work_valid_hour_day;
            
            console.log("concentration > 0");
        }
        else {
            var hours_required_year = activity_total / activity_performance;
            var hours_required_day  = activity_total / activity_performance;
            var direct_work_year    = activity_total / activity_performance;
            var direct_work_hour    = activity_total / activity_performance;
            console.log("ELSE");
        }
    
        div.find('#hours_required_year').val(Math.round(hours_required_year));
        div.find('#hours_required_day').val(hours_required_day.toFixed(2));
        div.find('#direct_work_year').val(direct_work_year.toFixed(5));
        div.find('#direct_work_hour').val(direct_work_hour.toFixed(5));
    });

    $(document).on('keyup', '.calculate-designated', function() {

        var div = $(this).closest('.dynamic-element');
        var designated_hours_weeks = div.find('#designated_hours_weeks').val();
        var habil_days = div.find('#habil_days').val();
        var work_valid_hour_day = div.find('#work_valid_hour_day').val();

        if(designated_hours_weeks == 0)
        {
            div.find('#hours_required_year').val('');
            div.find('#hours_required_day').val('');
            div.find('#direct_work_year').val('');
            div.find('#direct_work_hour').val('');
            return;
        }

        var hours_required_year = designated_hours_weeks * (habil_days/5);
        var hours_required_day  = designated_hours_weeks/5;
        var direct_work_year    = hours_required_day/work_valid_hour_day;
        var direct_work_hour    = direct_work_year/work_valid_hour_day;
    
        div.find('#hours_required_year').val(Math.round(hours_required_year));
        div.find('#hours_required_day').val(hours_required_day.toFixed(2));
        div.find('#direct_work_year').val(direct_work_year.toFixed(5));
        div.find('#direct_work_hour').val(direct_work_hour.toFixed(5));
    });

    //Clone the hidden element and shows it
    $('.add-one').click(function(){
        var newElement = $('.dynamic-element').first().clone();
        var num = $('.dynamic-element').length - 2;
        var newNum = num + 1;
        newElement.find('input,select').each(function(i){
            $(this).attr('name', $(this).attr('name').replace($(this).attr("name").match(/\[[0-9]+\]/), "["+(newNum)+"]"));
            $(this).prop('disabled', false);
            $(this).prop('required', true);
        });
        newElement.find(':hidden').each(function(i){
            $(this).find('input:first').prop('required', false);
        });
        newElement.appendTo('.dynamic-stuff').show();
    });
    $('.add-one').click();

    $('#activity_submit').click(function(){
        if($('#activity_name').val().length === 0){
            $('#activity_search_id').focus();
            alert('Seleccione actividad del listado para avanzar')
            return false
        }
        
    });
    
</script>


@endsection
