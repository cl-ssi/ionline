@extends('layouts.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-cog"></i> Mantenedor de Perfiles Estamento.</h5>

<br>

<div class="row">
    <div class="col-sm">
      <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.manage.profile.update', $profileManage) }}">
          @csrf
          @method('PUT')
          <fieldset class="form-group col">
              <label for="for_name">Nombre de Perfil</label>
                  <input type="text" class="form-control" name="name" value="{{ $profileManage->name }}">
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
