@extends('layouts.app')

@section('title', 'Días Habiles')

@section('content')

@include('programmings/nav')


@if($programmingDays)
<h3 class="mb-3"> Actualizar Días Hábiles a Programar</h3>
<form method="POST" class="form-horizontal small" action="{{ route('programmingdays.update',$programmingDays->id) }}" >
@csrf
@method('PUT')
@else
<h3 class="mb-3"> Días Hábiles a Programar</h3>
<form method="POST" class="form-horizontal small" action="{{ route('programmingdays.store') }}" >
@csrf   
@endif


<input type="hidden" class="form-control" id="forreferente" name="programming_id" value="{{Request::get('programming_id')}}">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Fines de Semana</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="weekends" placeholder=""  name="weekends" value="{{$programmingDays->weekends ?? '0' }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Feriados</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="national_holidays" placeholder=""  name="national_holidays" value="{{$programmingDays->national_holidays ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">1/2 Día Estamento</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="noon_estament" placeholder=""  name="noon_estament" value="{{$programmingDays->noon_estament ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">1/2 día Fiestas</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="noon_parties" placeholder=""  name="noon_parties" value="{{$programmingDays->noon_parties ?? '0'}}">
      <small> Fiestas Patrias,  Navidad y Año Nuevo </small>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Capacitación</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="training" placeholder=""  name="training" value="{{$programmingDays->training ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Vacaciones</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="holidays" placeholder=""  name="holidays" value="{{$programmingDays->holidays ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Permisos Administrativos</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="administrative_permits" placeholder=""  name="administrative_permits" value="{{$programmingDays->administrative_permits ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Almuerzo Asociaciones</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="associations_lunches" placeholder=""  name="associations_lunches" value="{{$programmingDays->associations_lunches ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Otros</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="others" placeholder=""  name="others" value="{{$programmingDays->others ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Total a Restar</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="days_year" placeholder=""  name="days_year" value="{{$programmingDays->days_year ?? '0'}}" readonly>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">DIAS A PROGRAMAR</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="days_programming" placeholder=""  name="days_programming" value="{{$programmingDays->days_programming ?? '0'}}">
    </div>
  </div>

  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Jornada Directa</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" id="day_work_hours" placeholder=""  name="day_work_hours" value="{{$programmingDays->day_work_hours ?? '0'}}">
      <small>* Calculo de horas de trabajo diaria</small>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-10">
    @if($programmingDays)
    <button type="submit" class="btn btn-primary">Actualizar</button>
    @else
    <button type="submit" class="btn btn-primary">Guardar</button>
    @endif

      
    </div>
  </div>
</form>


@endsection


@section('custom_js')

<script>
    $('#weekends, #national_holidays, #noon_estament, #noon_parties, #training, #holidays, #administrative_permits, #associations_lunches, #others').keyup(function() {
        
        var weekends         = $('#weekends').val();
        var national_holidays  = $('#national_holidays').val();
        var noon_estament   = $('#noon_estament').val();
        var noon_parties            = $('#noon_parties').val();
        var training = $('#training').val();
        var holidays     = $('#holidays').val();
        var administrative_permits            = $('#administrative_permits').val();
        var associations_lunches = $('#associations_lunches').val();
        var others     = $('#others').val();

        //console.log("rate "+tec_salud+" coverture "+med_odont_qf);

        if(weekends == 0 && national_holidays == 0 && noon_estament == 0  && noon_parties == 0 && training == 0 && holidays == 0 && administrative_permits == 0 && associations_lunches == 0 && others == 0) 
        {
            var calc = $('#days_year').val();
            console.log("prevalence_rate == 0 && coverture == 0");
        }
        
        else 
        {
            var calc = parseFloat(weekends) + parseFloat(national_holidays) + parseFloat(noon_estament)+
                      parseFloat(administrative_permits) + parseFloat(associations_lunches) + parseFloat(others)+
                      parseFloat(noon_parties) + parseFloat(training) + parseFloat(holidays);
            console.log("prevalence_rate > 0 && coverture == 0");
            
        }
    
        $('#days_year').val(calc.toFixed(2));
        $('#days_programming').val(366-calc.toFixed(2));
        
    });


    
</script>


@endsection
