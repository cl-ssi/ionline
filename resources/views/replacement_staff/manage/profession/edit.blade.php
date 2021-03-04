@extends('layouts.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-cog"></i> Mantenedor de Profesiones.</h5>

<br>

<div class="row">
    <div class="col-sm">
      <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.manage.profession.update', $professionManage) }}">
          @csrf
          @method('PUT')
          <fieldset class="form-group col">
              <label for="for_name">Nombre de Profesión</label>
                  <input type="text" class="form-control" name="name" value="{{ $professionManage->name }}">
          </fieldset>
          <button type="submit" class="btn btn-primary float-right">Guardar</button>
      </form>
    </div>

    <div class="col-sm">

    </div>
</div>

@endsection

@section('custom_js')

@endsection
