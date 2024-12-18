@extends('layouts.bt4.app')

@section('title', 'Item Programación')

@section('content')

@include('programmings/nav')



<h4 class="mb-3">
    <a href="{{ Session::has('items_url') ? Session::get('items_url') : url()->previous() }}" class="btn btb-flat btn-sm btn-dark" >
                    <i class="fas fa-arrow-left small"></i> 
                    <span class="small">Volver</span> 
    </a>
Editar Item Programación Operativa </h4>





<hr>
<form id="edit-form" method="POST" class="form-horizontal small" action="{{ route('programmingitems.update',$programmingItem->id) }}">
@csrf  
@method('PUT')
</form>

@if($programmingItem->activity_subtype != null)
<!-- Actividad indirecta esporadica o por designación -->
    <div class="form-row small">
        <div class="form-group col-md-3">
            <label for="forprogram">Subtipo de actividad indirecta</label>
            <select name="activity_subtype" id="activity_subtype"  class="form-control" form="edit-form" disabled>
                <option value="Esporádicas" {{$programmingItem->activity_subtype == 'Esporádicas' ? 'selected': ''}}>Actividades Esporádicas</option>
                <option value="Designación" {{$programmingItem->activity_subtype == 'Designación' ? 'selected': ''}}>Designación de horas funcionarios por rol</option>
            </select>
        </div>

        @if($programmingItem->activity_subtype == 'Esporádicas')
        <div class="form-group col-md-3" id="activity_category_div">
            <label for="forprogram">Categoría</label>
            <select name="activity_category" id="activity_category" class="form-control" form="edit-form" required>
                <option value="">Seleccione opción</option>
                @php($categories = array('Reunión', 'Jornada', 'Consultoría', 'Supervisión Interna', 'Plan de Intervención (N° familias)', 
                                        'Trabajo administrativo', 'Viaje de ronda', 'Tele interconsulta', 'Tele consultoría'))
                @foreach($categories as $category)
                <option value="{{$category}}" {{$programmingItem->activity_category == $category ? 'selected' : ''}}>{{$category}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6" id="activity_name_div">
            <label for="forprogram">Nombre de la actividad</label>
            <input type="input" class="form-control" id="activity_name" name="activity_name" value="{{$programmingItem->activity_name}}" form="edit-form" required>
        </div>
        @else
        <div class="form-group col-md-3" id="work_area_div">
            <label for="forprogram">Área de trabajo</label>
            <select name="work_area" id="work_area" class="form-control" form="edit-form">
                <option value="">Seleccione opción</option>
                @php($work_areas = array('Dirección', 'SOME', 'Esterilización', 'Interconsulta', 'Epidemiología', 'SIGGES', 'OIRS', 'Informática',
                                        'Estadísticas', 'Sala de Tratamiento', 'Farmacia', 'Bodega de Leche', 'Dental', 'Referencia de programa', 'Otro'))
                @foreach($work_areas as $work_area)
                <option value="{{$work_area}}" {{$programmingItem->work_area == $work_area ? 'selected' : ''}}>{{$work_area}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3" id="another_work_area_div">
            <label for="forprogram">Otro, ¿Cúal?</label>
            <input type="input" class="form-control" id="another_work_area" name="another_work_area" value="{{$programmingItem->another_work_area}}" form="edit-form" readonly>
        </div>
        <div class="form-group col-md-3" id="work_area_specs_div">
            <label for="forprogram">Especificaciones área de trabajo</label>
            <input type="input" class="form-control" id="work_area_specs" name="work_area_specs" value="{{$programmingItem->work_area_specs}}" form="edit-form">
        </div>
        @endif
    </div>
    @if($programmingItem->activity_subtype == 'Esporádicas')
    <div class="form-row small">
        <div class="form-group col-md-2" id="times_month_div">
            <label for="forprogram">N° veces al mes</label>
            <input type="number" class="form-control" id="times_month" name="times_month" value="{{$programmingItem->times_month}}" form="edit-form" required>
        </div>
        <div class="form-group col-md-2" id="months_year_div">
            <label for="forprogram">N° meses del año</label>
            <input type="number" class="form-control" id="months_year" name="months_year" value="{{$programmingItem->months_year}}" form="edit-form" required>
        </div>
        <div class="form-group col-md-2" id="activity_total_div">
            <label for="forprogram">Total Actividad</label>
            <input type="input" class="form-control" id="activity_total" name="activity_total" value="{{$programmingItem->activity_total}}" required="" form="edit-form" readonly>
        </div>
    </div>
    @endif
@else
    <div class="form-row small">
        <div class="form-group col-md-2">
            <label for="forprogram">Tipo Actividad</label>
            <select name="activity_type" id="activity_type" class="form-control" form="edit-form" required>
                {{--@php($activity_types = array('Directa', 'Indirecta'))
                <option value="">-- Seleccione tipo --</option>
                @foreach($activity_types as $activity_type)
                <option value="{{$activity_type}}" @if($activity_type == $programmingItem->activity_type) selected @endif>{{$activity_type}}</option>
                @endforeach--}}
                <option value="Directa">Directa</option>
            </select>
        </div>
        @if($programmingItem->activityItem == null || ($programmingItem->activityItem && $programmingItem->activityItem->tracer == 'NO'))
        <div class="form-group col-md-6">
            <label for="forprogram">Ciclo Vital</label>
            <select name="cycle" id="formprogram" class="form-control" form="edit-form" required>
                @php($cycle_types = array('INFANTIL', 'ADOLESCENTE', 'ADULTO', 'ADULTO MAYOR', 'TRANSVERSAL'))
                <option value="">-- Seleccione ciclo vital --</option>
                @foreach($cycle_types as $cycle_type)
                <option value="{{$cycle_type}}" @if($cycle_type == $programmingItem->cycle) selected @endif>{{$cycle_type}}</option>
                @endforeach
            </select>
        </div>
        @else
        <div class="form-group col-md-6">
            <label for="forprogram">Ciclo Vital</label>
            <input type="input" class="form-control" id="cycle_type" name="cycle_type" value="{{ $programmingItem->activityItem->vital_cycle ?? $programmingItem->cycle }}" required="" form="edit-form" readonly>
        </div>
        @endif
    </div>
    <div class="form-row small">

    @if($programmingItem->activityItem == null || ($programmingItem->activityItem && $programmingItem->activityItem->tracer == 'NO'))
    <div class="form-group col-md-2">
        <label for="forprogram">Acción</label>
        <select name="action_type" id="action_type" class="form-control" form="edit-form" required>
        @php($action_types = array('Prevención', 'Diagnóstico', 'Tratamiento', 'Promoción'))
            <option value="">-- Seleccione acción --</option>
            @foreach($action_types as $action_type)
            <option value="{{$action_type}}" @if($action_type == $programmingItem->action_type) selected @endif>{{$action_type}}</option>
            @endforeach           
        </select>
    </div>
    <div class="form-group col-md-10">
        <label for="forprogram">Actividad o Prestación</label>
        <select style="font-size:70%;" name="activity_id" id="activity_id" class="form-control selectpicker" data-live-search="true" form="edit-form" required>
            <option value="">-- Seleccione actividad NO trazadora --</option>
            @foreach($activityItems as $activity)
            <option style="font-size:70%;" value="{{$activity->id}}" @if($activity->id == $programmingItem->activity_id) selected @endif>
                        {{ $activity->activity_name }} - 
                        {{ $activity->def_target_population }} - 
                        {{ $activity->professional }}</option>
            @endforeach           
        </select>
    </div>
    @else
        <div class="form-group col-md-2">
            <label for="forprogram">Acción</label>
            <input type="input" class="form-control" id="action_type" name="action_type" value="{{$programmingItem->activityItem->action_type ?? $programmingItem->action_type }}" required="" form="edit-form" disabled>
        </div>
        <div class="form-group col-md-10">
            <label for="forprogram">Actividad o Prestación</label>
            <input type="input" class="form-control" id="activity_name" name="activity_name" value="{{$programmingItem->activityItem->activity_name ?? $programmingItem->activity_name }}" required="" form="edit-form" disabled>
        </div>
        <input type="hidden" class="form-control" id="activity_id" name="activity_id" value="{{$programmingItem->activity_id ?? '' }}" required="">
    @endif

    </div>

    <div class="form-row small">
    
        <div class="form-group col-md-8">
            <label for="forprogram">Def. Población Objetivo</label>
            <input type="input" class="form-control" id="forreferente" name="def_target_population" value="{{$programmingItem->activityItem->def_target_population ?? $programmingItem->def_target_population }}"  form="edit-form" required="">
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Fuente Población</label>
            <input type="input" class="form-control " id="forreferente" name="source_population" value="{{$programmingItem->source_population ?? '' }}" required="" form="edit-form">
            <small>Ej. Fonasa - Tarjetero Electrónico</small>
        </div>
    </div>

    <div class="form-row small">
    

        <div class="form-group col-md-2">
            <label for="forprogram">Nº Población Objetivo</label> 
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Población Objetivo" 
            data-content="Expresar numéricamente la cantidad de población Ej: 15000">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" class="form-control " id="cant_target_population" name="cant_target_population" value="{{$programmingItem->cant_target_population ?? '1' }}" required="" form="edit-form">
        </div>
        <div class="form-group col-md-2">
        <label for="forprogram">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="prevalence_option" id="prevalence_option" form="edit-form" {{$programmingItem->prevalence_rate != null ? 'checked' : ''}}>
                <label class="form-check-label" for="prevalence_option">
                Prevalencia o Tasa (%)
                </label>
            </div>
            </label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Prevalencia o Tasa (%)" 
            data-content="Utilizar este dato cuando se desconoce el número de usuarios con el fin de estimar una población que podría percibir en el año a programar Ej: 50%">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control" id="prevalence_rate" name="prevalence_rate" value="{{$programmingItem->prevalence_rate}}" form="edit-form" {{ $programmingItem->prevalence_rate != null ? 'required' : 'disabled' }}>
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Fuente Prevalencia o Tasa</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Fuente Prevalencia o Tasa" 
            data-content="En caso de utilizar prevalencia/tasa, se debe indicar la fuente del dato Ej: Minsal">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="forreferente" name="source_prevalence" value="{{$programmingItem->source_prevalence ?? '' }}" form="edit-form" >
            <small></small>
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Cobertura (%)</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Cobertura (%)" 
            data-content="Es el porcentaje de la población que se va a atender. Se expresa en porcentaje. Las prestaciones universales se deben consignar por sobre un 90% de cobertura Ej: 43%">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control" id="coverture" name="coverture" value="{{$programmingItem->coverture ?? '1' }}" required="" form="edit-form">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Nº Población a Atender</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Población a Atender" 
            data-content="Es el cálculo matemático de una actividad ponderada: multiplicación de la población por su incidencia/prevalencia y por la cobertura.">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" class="form-control" id="population_attend" name="population_attend" value="{{$programmingItem->population_attend ?? '1' }}" required="" readonly form="edit-form">
        </div>
        
    </div>

    <div class="form-row small">

        <div class="form-group col-md-2">
            <label for="forprogram">Concentración</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Concentración" 
            data-content="La cantidad de veces que debo darle el control anual">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" class="form-control" id="concentration" name="concentration" value="{{$programmingItem->concentration ?? '1'}}" {{ $programmingItem->workshop == 'SI' ? 'readonly' : 'required'  }} form="edit-form">
        </div>
        @if($programmingItem->workshop == 'SI')
        <div class="form-group col-md-2">
            <label for="forprogram">N° De Personas por Grupo</label>
            <input type="number" class="form-control" id="activity_group" name="activity_group" value="{{$programmingItem->activity_group ?? '1' }}" form="edit-form">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">N° De Talleres</label>
            <input type="number" class="form-control" id="workshop_number" name="workshop_number"  value="{{$programmingItem->workshop_number ?? '1' }}" form="edit-form" readonly >
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">N° De Sesión por Talleres</label>
            <input type="number" class="form-control" id="workshop_session_number" name="workshop_session_number" value="{{$programmingItem->workshop_session_number ?? '1' }}" form="edit-form" > 
        </div>
        @endif
        <div class="form-group col-md-2">
            <label for="forprogram">Total Actividad</label>
            <input type="input" class="form-control" id="activity_total" name="activity_total" value="{{$programmingItem->activity_total ?? '1' }}" required="" readonly form="edit-form">
        </div>
        
    </div>
    @endif

    @if($programmingItem->professionalHours->count() > 0)
    <!-- hidden dynamic element to clone -->
    @foreach($programmingItem->professionalHours as $key => $proHour)
    <div class="form-group dynamic-element">
    <hr>
    <div class="form-row small">
    
        <div class="form-group col-md-6">
            <label for="forprogram">Profesional/Funcionario</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Profesional/Funcionario" 
            data-content="Funcionario que otorga la prestación, Si es más de un funcionario para la actividad programada se debe repetir en otro registro">
            <i class="fas fa-info-circle"></i></a> 
            <form id="delete-form-{{$proHour->id}}" method="POST" class="d-inline" action="{{ route('programmingitems.destroyProfessionalHour', [ 'programmingitem' => $programmingItem->id, 'id' => $proHour->pivot->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link btn-sm float-right m-0 p-0" onclick="return confirm('¿Desea eliminar este item?')"><span class="fas fa-trash-alt" style="color:red" aria-hidden="true"></span></button>
            </form>
            <select name="professionals[{{$key}}][professional_hour_id]" id="formprogram" class="form-control" form="edit-form">
                @foreach($professionalHours as $professionalHour)
                    <option value="{{ $professionalHour->id }}" {{$professionalHour->id == $proHour->pivot->professional_hour_id ? 'selected': ''}}>{{ $professionalHour->professional->alias ?? '' }}</option>
                @endforeach
            </select>
        </div>

        @if($programmingItem->activity_subtype == 'Designación')
        <div class="form-group col-md-3" id="designated_hours_weeks_div">
            <label for="forprogram">Horas/semanas designadas</label>
            <input type="number" setp="any" class="form-control calculate-designated" id="designated_hours_weeks" name="professionals[{{$key}}][designated_hours_weeks]" value="{{$proHour->pivot->designated_hours_weeks}}" form="edit-form">
        </div>
        @else
        <div class="form-group col-md-3">
            <label for="forprogram">Rendimiento de la Actividad</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Rendimiento de la Actividad" 
            data-content="Número de veces que se realiza un tipo de actividad durante una hora cronológica por parte de un funcionario 
            (EJ: Rendimiento de 45 minutos es 60/45=1.3).
             Cuando el rendimiento está normado debe utilizarse el estandar de la norma o uno menor según acuerdo local.">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control calculate-performance" id="activity_performance" name="professionals[{{$key}}][activity_performance]" value="{{$proHour->pivot->activity_performance}}" form="edit-form">
        </div>
        @endif

        <div class="form-group col-md-2">
            <label for="forprogram">Total Día Habiles</label>
            <input type="number" class="form-control" id="habil_days" value="{{ $programmingDays ? $programmingDays->days_programming : '' }}" name="professionals[{{$key}}][habil_days]" form="edit-form" readonly>
        </div>

        <div class="form-group col-md-1">
            <label for="forprogram">Hora Laboral</label>
            <input type="number" class="form-control" id="work_valid_hour_day" value="{{ $programmingDays ? $programmingDays->day_work_hours : '' }}" name="professionals[{{$key}}][work_valid_hour_day]" form="edit-form" readonly>
        </div>
        
    </div>

    <div class="form-row small">

        <div class="form-group col-md-3">
            <label for="forprogram">Horas Años Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas Años Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_year" name="professionals[{{$key}}][hours_required_year]" value="{{$proHour->pivot->hours_required_year}}" form="edit-form" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Horas días Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas días Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en un dia del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_day" name="professionals[{{$key}}][hours_required_day]" value="{{$proHour->pivot->hours_required_day}}" form="edit-form" readonly>
        </div>
    
        <div class="form-group col-md-s">
            <label for="forprogram">Jornadas Directas Año</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Directas Año" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_year" name="professionals[{{$key}}][direct_work_year]" value="{{$proHour->pivot->direct_work_year ? number_format($proHour->pivot->direct_work_year, 5, '.', '') : 0}}" form="edit-form" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Jornadas Horas Directas Diarias</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Horas Directas Diarias" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en un día del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_hour" name="professionals[{{$key}}][direct_work_hour]" value="{{$proHour->pivot->direct_work_hour ? number_format($proHour->pivot->direct_work_hour, 5, '.', '') : 0}}" form="edit-form" readonly>
        </div>
    </div>
    </div>
    @endforeach
    <!-- end hidden dynamic element to clone -->
    <div class="dynamic-stuff"></div>
    <button type="button" class="btn btn-link mx-auto d-block add-one">+ Añadir otro profesional</button>
    <hr>
    @else
    <div class="form-row small">
    
        <div class="form-group col-md-6">
            <label for="forprogram">Profesional/Funcionario <span class="text-danger"></span></label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Profesional/Funcionario" 
            data-content="Funcionario que otorga la prestación, Si es más de un funcionario para la actividad programada se debe repetir en otro registro">
            <i class="fas fa-info-circle"></i></a>
            <select name="professional" id="formprogram" class="form-control" form="edit-form">
                <option value=""></option>
                @foreach($professionalHours as $professionalHour)
                    <option value="{{ $professionalHour->id }}" @if(isset($professionalHoursSel) && $professionalHour->alias == $professionalHoursSel->alias) selected @endif>{{ $professionalHour->alias }}</option>
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
            <input type="number" step="any" class="form-control" id="activity_performance" name="activity_performance" value="{{$programmingItem->activity_performance ?? '0' }}" required="" form="edit-form">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Total Día Habiles</label>
            <input type="number" class="form-control" id="habil_days" value="{{ $programmingDays ? $programmingDays->days_programming : '' }}" name="habil_days"  required="" form="edit-form" readonly>
        </div>

        <div class="form-group col-md-1">
            <label for="forprogram">Hora Laboral</label>
            <input type="number" class="form-control" id="work_valid_hour_day" value="{{ $programmingDays ? $programmingDays->day_work_hours : '' }}" name="work_valid_hour_day"  required="" form="edit-form" readonly>
        </div>
        
    </div>

    <div class="form-row small">

        <div class="form-group col-md-3">
            <label for="forprogram">Horas Años Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas Años Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_year" name="hours_required_year" required="" value="{{$programmingItem->hours_required_year ?? '0' }}" form="edit-form" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Horas días Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas días Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en un dia del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_day" name="hours_required_day" required="" value="{{$programmingItem->hours_required_day ?? '0' }}" form="edit-form" readonly>
        </div>
    
        <div class="form-group col-md-s">
            <label for="forprogram">Jornadas Directas Año</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Directas Año" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_year" name="direct_work_year" required=""  value="{{$programmingItem->direct_work_year ?? '0' }}" form="edit-form" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Jornadas Horas Directas Diarias</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Horas Directas Diarias" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en un día del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_hour" name="direct_work_hour" required=""  value="{{$programmingItem->direct_work_hour ?? '0' }}" form="edit-form" readonly>
        </div>
    </div>
    @endif

    <div class="form-row small">

        <div class="form-group col-md-6">
            <label for="forprogram">Fuente Información</label>
            <input type="input" class="form-control" id="information_source" name="information_source"  value="{{$programmingItem->activityItem->verification_rem ?? $programmingItem->information_source }}" form="edit-form">
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Financiada por Prap</label>
            <select name="prap_financed" id="prap_financed" class="form-control" form="edit-form">
                    <!-- <option value="option_select" disabled selected>{{$programmingItem->prap_financed ?? '' }}</option> -->
                @php($financed = array('NO', 'SI'))
                @foreach($financed as $option)
                    <option value="{{$option}}" @if($option == $programmingItem->prap_financed) selected @endif>{{$option}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-row small">
        
        <div class="form-group col-md-12">
            <label for="forprogram">Observación</label>
            <input type="input" class="form-control" id="observation" name="observation" value="{{$programmingItem->observation ?? '' }}" form="edit-form">
        </div>
        
    </div>

    @if(request()->has('review_id'))
    <input type="hidden" name="review_id" value="{{request()->review_id}}" form="edit-form">
    <div class="form-row small">
        <div class="form-group col-md-12">
            <label for="exampleFormControlTextarea1">Comentarios/Acuerdo a la observación #{{request()->review_id}}:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="rect_comments" rows="5" form="edit-form">{{$reviewItem->rect_comments}}</textarea>
        </div>
    </div>
    @endif

    
    <button type="submit" class="btn btn-info mb-4" form="edit-form">Actualizar</button>

    @can('Programming: audit')
    <hr/>

        <h6><i class="fas fa-info-circle"></i> Auditoría Interna</h6>

        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Item de programación
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        @include('partials.audit', ['audits' => $programmingItem->audits()])
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                                data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Profesionales Horas
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <h6 class="mt-3 mt-4">Historial de cambios</h6>
                        <div class="table-responsive-md">
                            <table class="table table-sm small text-muted mt-3">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Modificaciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($programmingItem->professionalHours as $professionalHour)
                                    @if($professionalHour->pivot->audits->count() > 0)
                                        @foreach($professionalHour->pivot->audits->sortByDesc('updated_at') as $audit)
                                            <tr>
                                                <td nowrap>{{ $audit->created_at }}</td>
                                                <td nowrap>{{ optional($audit->user)->fullName }}</td>
                                                <td>
                                                    @foreach($audit->getModified() as $attribute => $modified)
                                                        @if(isset($modified['old']) OR isset($modified['new']))
                                                            <strong>{{ $attribute }}</strong>
                                                            :  {{ isset($modified['old']) ? $modified['old'] : '' }}
                                                            => {{ $modified['new'] }};
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan



@endsection

@section('custom_js')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script>

    // $('#activity_subtype').change(function() {
    //     if($(this).find('option:selected').val() == 'Designación'){
    //         $('#work_area_div,#another_work_area_div,#designated_hours_weeks_div,#work_area_specs_div').show();
    //         $('#work_area').prop('required', true);
    //         $('#activity_category_div,#activity_name_div,#times_month_div,#months_year_div,#activity_total_div,#activity_performance_div').hide();
    //         $('#activity_category,#activity_name,#times_month,#months_year,#activity_total,#activity_performance').prop('required', false).val('');
    //     }else{
    //         $('#work_area_div,#another_work_area_div,#designated_hours_weeks_div,#work_area_specs_div').hide();
    //         $('#work_area,#another_work_area,#designated_hours_weeks,#work_area_specs').prop('required', false).val('');
    //         $('#activity_category_div,#activity_name_div,#times_month_div,#months_year_div,#activity_total_div,#activity_performance_div').show();
    //         $('#activity_category,#activity_name,#times_month,#months_year,#activity_total,#activity_performance').prop('required', true);
    //     }
    // });

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
        var num = $('.dynamic-element').length - 1;
        var newNum = num + 1;
        newElement.find('input,select').each(function(i){
            $(this).attr('name', $(this).attr('name').replace($(this).attr("name").match(/\[[0-9]+\]/), "["+(newNum)+"]"));
            $(this).prop('disabled', false);
            $(this).prop('required', true);
            if(!['habil_days', 'work_valid_hour_day'].includes($(this).attr('id'))) $(this).val('');
        });
        newElement.find(':hidden').each(function(i){
            $(this).find('input:first').prop('required', false);
        });
        newElement.find('form').remove();
        newElement.appendTo('.dynamic-stuff').show();
    });

    // if close child window after submit this form refresh parent window
    window.onunload = function(){
        window.opener.location.reload();
    };
    
</script>


@endsection
