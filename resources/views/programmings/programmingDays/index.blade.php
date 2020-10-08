@extends('layouts.app')

@section('title', 'Lista de Profesionales')

@section('content')

@include('programmings/nav')

<h3 class="mb-3"> Días Hábiles a Programar</h3>

<form>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Fines de Semana</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->weekends ?? '0' }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Feriados</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->national_holidays ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">1/2 Día Estamento</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->noon_estament ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">1/2 día Fiestas</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->noon_parties ?? '0'}}">
      <small> Fiestas Patrias,  Navidad y Año Nuevo </small>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Capacitación</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->training ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Vacaciones</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->holidays ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Permisos Administrativos</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->administrative_permits ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Almuerzo Asociaciones</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->associations_lunches ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Otros</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->others ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Total a Restar</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->days_year ?? '0'}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">DIAS A PROGRAMAR 2020</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="" value="{{$programmingDays->days_programming ?? '0'}}">
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
  </div>
</form>


@endsection
