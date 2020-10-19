@extends('layouts.app')

@section('title', 'Item Programación')

@section('content')

@include('programmings/nav')



<h4 class="mb-3">
    <a href="{{ route('programmingitems.index', ['programming_id' => Request::get('programming_id')]) }}" class="btn btb-flat btn-sm btn-dark" >
                    <i class="fas fa-arrow-left small"></i> 
                    <span class="small">Volver</span> 
    </a>
Nuevo Item Programación Operativa </h4>




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
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="forprogram">Ciclo Vital</label>
            <select name="cycle" id="formprogram" class="form-control">
                    <option value="INFANTIL">INFANTIL</option>
                    <option value="ADOLESCENTE">ADOLESCENTE</option>
                    <option value="ADULTO">ADULTO</option>
                    <option value="ADULTO MAYOR">ADULTO MAYOR</option>
                    <option value="TRANSVERSAL">TRANSVERSAL</option>
                    <option value="TALLER">TALLER</option>
               
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="forprogram">Acción</label>
            <input type="input" class="form-control" id="activity_name" name="activity_name" value="{{ $activityItemsSelect ? $activityItemsSelect->action_type : '' }}" required="">
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
            <label for="forprogram">Trazadora</label>
            <input type="input" class="form-control" id="tracer" name="tracer" value="{{ $activityItemsSelect ? $activityItemsSelect->tracer : '' }}" required="">
        </div>
    
        <div class="form-group col-md-9">
            <label for="forprogram">Actividad o Prestación</label>
            <input type="input" class="form-control" id="action_type" name="action_type" value="{{ $activityItemsSelect ? $activityItemsSelect->activity_name : '' }}" required="">
        </div>

    </div>

    <div class="form-row">
    
        <div class="form-group col-md-8">
            <label for="forprogram">Def. Población Objetivo</label>
            <input type="input" class="form-control" id="forreferente" name="def_target_population" value="{{ $activityItemsSelect ? $activityItemsSelect->def_target_population : '' }}" required="">
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
            <input type="number" class="form-control " id="cant_target_population" name="cant_target_population"  required="">
        </div>
        <div class="form-group col-md-2">
            <label for="forprogram">Prevalencia o Tasa (%)</label>
            <input type="number" class="form-control" id="prevalence_rate" name="prevalence_rate" required="">
        </div>

        <div class="form-group col-md-4">
            <label for="forprogram">Fuente Prevalencia o Tasa</label>
            <input type="input" class="form-control" id="forreferente" name="source_prevalence" >
            <small></small>
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Cobertura (%)</label>
            <input type="number" class="form-control" id="coverture" name="coverture" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Nº Población a Atender</label>
            <input type="number" class="form-control" id="population_attend" name="population_attend" required="" readonly>
        </div>
        
    </div>

    <div class="form-row">

        <div class="form-group col-md-2">
            <label for="forprogram">Concentración</label>
            <input type="number" class="form-control" id="concentration" name="concentration" required="">
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Total Actividad</label>
            <input type="input" class="form-control" id="activity_total" name="activity_total" value="" required="" readonly>
        </div>
        
    </div>

    <div class="form-row">
    
        <div class="form-group col-md-6">
            <label for="forprogram">Profesional <span class="text-danger">{{ $activityItemsSelect ? '- Rec. '.$activityItemsSelect->professional : '' }}</span></label>
            <select name="professional" id="formprogram" class="form-control">
                @foreach($professionalHours as $professionalHour)
                    <option value="{{ $professionalHour->id }}">{{ $professionalHour->alias }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Rendimiento de la Actividad</label>
            <input type="number" class="form-control" id="activity_performance" name="activity_performance" required="" >
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Total Día Habiles</label>
            <input type="number" class="form-control" id="habil_days" value="{{ $programmingDays ? $programmingDays->days_programming : '' }}" name="habil_days" required="" readonly>
        </div>

        <div class="form-group col-md-2">
            <label for="forprogram">Hora Laboral</label>
            <input type="number" class="form-control" id="work_valid_hour_day" value="{{ $programmingDays ? $programmingDays->day_work_hours : '' }}" name="work_valid_hour_day" required="" readonly>
        </div>
        
    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            <label for="forprogram">Horas Años Requeridas</label>
            <input type="input" class="form-control" id="hours_required_year" name="hours_required_year" required="" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Horas días Requeridas</label>
            <input type="input" class="form-control" id="hours_required_day" name="hours_required_day" required="" readonly>
        </div>
    
        <div class="form-group col-md-s">
            <label for="forprogram">Jornadas Directas Año</label>
            <input type="input" class="form-control" id="direct_work_year" name="direct_work_year" required="" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Jornada Directa Año</label>
            <input type="input" class="form-control" id="direct_work_hour" name="direct_work_hour" required="" readonly>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="forprogram">Jornadas Horas Directas Diarias</label>
            <input type="input" class="form-control" id="information_source" value="{{ $activityItemsSelect ? $activityItemsSelect->verification_rem : '' }}" name="information_source" required="">
        </div>

        <div class="form-group col-md-3">
            <label for="forprogram">Financiada por Prap</label>
            <select name="prap_financed" id="prap_financed" class="form-control">
                    <option value="SI">No</option>
                    <option value="NO">SI</option>
               
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

@endsection

@section('custom_js')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script>
    var select = document.getElementById('activity_search_id');
        select.onchange = function(){
            this.form.submit();
     };


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
            var direct_work_year    = activity_performance/ hours_required_day ;
            var direct_work_hour    = hours_required_year / direct_work_year;
            
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
        $('#direct_work_hour').val(direct_work_hour.toFixed(4));
        
    });

    
</script>


@endsection
