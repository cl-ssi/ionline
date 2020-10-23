@extends('layouts.app')

@section('title', 'Item Programación')

@section('content')

@include('programmings/nav')



<h4 class="mb-3">
    <a href="{{ route('programmingitems.index', ['programming_id' => $programmingItem->programming_id]) }}" class="btn btb-flat btn-sm btn-dark" >
                    <i class="fas fa-arrow-left small"></i> 
                    <span class="small">Volver</span> 
    </a>
Editar Item Programación Operativa </h4>





<hr>
<form method="POST" class="form-horizontal small" action="{{ route('programmingitems.update',$programmingItem->id) }}" enctype="multipart/form-data">
@csrf  
@method('PUT') 
    <input type="hidden" class="form-control" id="programming_id" name="programming_id" value="{{Request::get('programming_id')}}">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="forprogram">Ciclo Vital</label>
            <select name="cycle" id="formprogram" class="form-control">
                    <option value="option_select" disabled selected>{{$programmingItem->cycle ?? '' }}</option>
                    <option value="INFANTIL">INFANTIL</option>
                    <option value="ADOLESCENTE">ADOLESCENTE</option>
                    <option value="ADULTO">ADULTO</option>
                    <option value="ADULTO MAYOR">ADULTO MAYOR</option>
                    <option value="TRANSVERSAL">TRANSVERSAL</option>
                    <option value="TALLER">TALLER</option>
               
            </select>
        </div>
        
        <!--<div class="form-group col-md-8">
            <label for="forprogram">Programa Ministerial</label>
            <select name="ministerial_program" id="formprogram" class="form-control selectpicker " data-live-search="true" required>
                @foreach($ministerialPrograms as $ministerialProgram)
                    <option value="{{ $ministerialProgram->id }}">{{ $ministerialProgram->name }}</option>
                @endforeach
            </select>
        </div>-->
    </div>
    <div class="form-row">

    <div class="form-group col-md-3">
            <label for="forprogram">Acción</label>
            <input type="input" class="form-control" id="action_type" name="action_type" value="{{$programmingItem->action_type ?? '' }}" required="" disabled>
        </div>
    
        <div class="form-group col-md-9">
            <label for="forprogram">Actividad o Prestación</label>
            <input type="input" class="form-control" id="activity_name" name="activity_name" value="{{$programmingItem->activity_name ?? '' }}" required="" disabled>
        </div>
        <input type="hidden" class="form-control" id="activity_id" name="activity_id" value="{{$programmingItem->activity_id ?? '' }}" required="">

    </div>

    <div class="form-row">
    
        <div class="form-group col-md-8">
            <label for="forprogram">Def. Población Objetivo</label>
            <input type="input" class="form-control" id="forreferente" name="def_target_population" value="{{$programmingItem->def_target_population ?? '' }}" required="" disabled>
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Fuente Población</label>
            <input type="input" class="form-control " id="forreferente" name="source_population" value="{{$programmingItem->source_population ?? '' }}" required="" >
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
            <input type="number" class="form-control " id="cant_target_population" name="cant_target_population" value="{{$programmingItem->cant_target_population ?? '0' }}" required="">
        </div>
        <div class="form-group col-md-2">
            <label for="forprogram">Prevalencia o Tasa (%)</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Prevalencia o Tasa (%)" 
            data-content="Utilizar este dato cuando se desconoce el número de usuarios con el fin de estimar una población que podría percibir en el año a programar Ej: 50%">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control" id="prevalence_rate" name="prevalence_rate" value="{{$programmingItem->prevalence_rate ?? '0' }}" required="">
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Fuente Prevalencia o Tasa</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Fuente Prevalencia o Tasa" 
            data-content="En caso de utilizar prevalencia/tasa, se debe indicar la fuente del dato Ej: Minsal">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="forreferente" name="source_prevalence" value="{{$programmingItem->source_prevalence ?? '' }}" >
            <small></small>
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Cobertura (%)</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Cobertura (%)" 
            data-content="Es el porcentaje de la población que se va a atender. Se expresa en porcentaje. Las prestaciones universales se deben consignar por sobre un 90% de cobertura Ej: 43%">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" step="any" class="form-control" id="coverture" name="coverture" value="{{$programmingItem->coverture ?? '0' }}" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Nº Población a Atender</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Población a Atender" 
            data-content="Es el cálculo matemático de una actividad ponderada: multiplicación de la población por su incidencia/prevalencia y por la cobertura.">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" class="form-control" id="population_attend" name="population_attend" value="{{$programmingItem->population_attend ?? '0' }}" required="" readonly>
        </div>
        
    </div>

    <div class="form-row">

        <div class="form-group col-md-2">
            <label for="forprogram">Concentración</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Concentración" 
            data-content="La cantidad de veces que debo darle el control anual">
            <i class="fas fa-info-circle"></i></a>
            <input type="number" class="form-control" id="concentration" name="concentration" value="{{$programmingItem->concentration ?? '0' }}" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Total Actividad</label>
            <input type="input" class="form-control" id="activity_total" name="activity_total" value="{{$programmingItem->activity_total ?? '0' }}" required="" readonly>
        </div>
        
    </div>

    <div class="form-row">
    
        <div class="form-group col-md-6">
            <label for="forprogram">Profesional/Funcionario <span class="text-danger">{{ $activityItemsSelect ? '- Rec. '.$activityItemsSelect->professional : '' }}</span></label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Profesional/Funcionario" 
            data-content="Funcionario que otorga la prestación, Si es más de un funcionario para la actividad programada se debe repetir en otro registro">
            <i class="fas fa-info-circle"></i></a>
            <select name="professional" id="formprogram" class="form-control">
            <option value="option_select" disabled selected>{{$professionalHoursSel->alias ?? '' }}</option>
                @foreach($professionalHours as $professionalHour)
                    <option value="{{ $professionalHour->id }}">{{ $professionalHour->alias }}</option>
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
            <input type="number" step="any" class="form-control" id="activity_performance" name="activity_performance" value="{{$programmingItem->activity_performance ?? '0' }}" required="" >
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Total Día Habiles</label>
            <input type="number" class="form-control" id="habil_days" value="{{ $programmingDays ? $programmingDays->days_programming : '' }}" name="habil_days"  required="" readonly>
        </div>

        <div class="form-group col-md-1">
            <label for="forprogram">Hora Laboral</label>
            <input type="number" class="form-control" id="work_valid_hour_day" value="{{ $programmingDays ? $programmingDays->day_work_hours : '' }}" name="work_valid_hour_day"  required="" readonly>
        </div>
        
    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            <label for="forprogram">Horas Años Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas Años Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_year" name="hours_required_year" required="" value="{{$programmingItem->hours_required_year ?? '0' }}" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Horas días Requeridas</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Horas días Requeridas" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de horas que se requieren en un dia del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="hours_required_day" name="hours_required_day" required="" value="{{$programmingItem->hours_required_day ?? '0' }}" readonly>
        </div>
    
        <div class="form-group col-md-s">
            <label for="forprogram">Jornadas Directas Año</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Directas Año" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en el año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_year" name="direct_work_year" required=""  value="{{$programmingItem->direct_work_year ?? '0' }}" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Jornadas Horas Directas Diarias</label>
            <a tabindex="0"  role="button" data-toggle="popover" data-trigger="focus" 
            title="Jornadas Horas Directas Diarias" 
            data-content="Calculo Automatico bajo fórmula que indica la cantidad de jornadas laborales que se requieren en un día del año programado.">
            <i class="fas fa-info-circle"></i></a>
            <input type="input" class="form-control" id="direct_work_hour" name="direct_work_hour" required=""  value="{{$programmingItem->direct_work_hour ?? '0' }}" readonly>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="forprogram">Fuente Información</label>
            <input type="input" class="form-control" id="information_source" name="information_source"  value="{{$programmingItem->information_source ?? '' }}" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Financiada por Prap</label>
            <select name="prap_financed" id="prap_financed" class="form-control">
                    <option value="option_select" disabled selected>{{$programmingItem->prap_financed ?? '' }}</option>
                    <option value="NO">No</option>
                    <option value="SI">SI</option>
               
            </select>
        </div>

        
        
    </div>



    <div class="form-row">
        
        <div class="form-group col-md-12">
            <label for="forprogram">Observación</label>
            <input type="input" class="form-control" id="observation" name="observation" value="{{$programmingItem->observation ?? '' }}" >
        </div>
        
    </div>

    
    <button type="submit" class="btn btn-info mb-4">Actualizar</button>

</form>

@endsection

@section('custom_js')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
    $('.popover-dismiss').popover({
        trigger: 'focus'
    }) 

    $('#prevalence_rate, #cant_target_population, #coverture').keyup(function() {
        
        var prevalence_rate = $('#prevalence_rate').val();
        var coverture       = $('#coverture').val();
        console.log("rate "+prevalence_rate+" coverture "+coverture);

        if(prevalence_rate == 0 && coverture == 0)
        {
            var calc = $('#cant_target_population').val();
            console.log("prevalence_rate == 0 && coverture == 0");
        }
        
        else if(prevalence_rate > 0 && coverture == 0)
        {
            var calc = $('#cant_target_population').val() * (prevalence_rate/100);
            console.log("prevalence_rate > 0 && coverture == 0");
            
        }
        else if(prevalence_rate == 0 && coverture > 0 )
        {
            var calc = $('#cant_target_population').val() * (coverture/100);
            console.log("prevalence_rate == 0 && coverture > 0");
        }
        else {
            var calc = $('#cant_target_population').val() * (prevalence_rate/100) * (coverture/100);
            console.log("ELSE");
            
        }
    
        $('#population_attend').val(Math.round(calc));


        // SEGUNDO INPUT
        var concentration       = $('#concentration').val();
        var population_attend   = $('#population_attend').val();

        if(concentration == 0)
        {
            var calc2 = $('#population_attend').val();
            console.log("concentration == 0");
        }
        
        else if(concentration > 0)
        {
            var calc2 = $('#population_attend').val() * concentration;
            console.log("concentration > 0");
            
        }
        else {
            var calc2 = $('#population_attend').val() * concentration;
            console.log("ELSE");
            
        }
    
        $('#activity_total').val(Math.round(calc2));

        // TERCER INPUT

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
        $('#direct_work_year').val(direct_work_year.toFixed(2));
        $('#direct_work_hour').val(direct_work_hour.toFixed(5));
        
    });

    $('#concentration').keyup(function() {
        
        var concentration       = $('#concentration').val();
        var population_attend   = $('#population_attend').val();

        if(concentration == 0)
        {
            var calc2 = $('#population_attend').val();
            console.log("concentration == 0");
        }
        
        else if(concentration > 0)
        {
            var calc2 = $('#population_attend').val() * concentration;
            console.log("concentration > 0");
            
        }
        else {
            var calc2 = $('#population_attend').val() * concentration;
            console.log("ELSE");
            
        }
    
        $('#activity_total').val(Math.round(calc2));

        // TERCER INPUT

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
        $('#direct_work_year').val(direct_work_year.toFixed(2));
        $('#direct_work_hour').val(direct_work_hour.toFixed(5));
        
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
        $('#direct_work_year').val(direct_work_year.toFixed(2));
        $('#direct_work_hour').val(direct_work_hour.toFixed(5));
        
    });

    
</script>


@endsection
