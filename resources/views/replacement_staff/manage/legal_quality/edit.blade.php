@extends('layouts.bt4.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-cog"></i> Mantenedor de Calidad Jurídica.</h5>

<br>

<div class="row">
    <div class="col-sm-6">
      <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.manage.legal_quality.assign_fundament', $legalQualityManage) }}">
          @csrf
          @method('POST')
          <fieldset class="form-group col">
              <label for="for_name">Calidad Jurídica</label>
                  <input type="text" class="form-control" name="name" value="{{ $legalQualityManage->NameValue }}" readonly>
          </fieldset>
          <!-- <fieldset class="form-group col mt">
              <label for="for_profile_manage_id">Estamento</label>
              <select name="profile_manage_id" class="form-control" wire:model.live="profileSelected" required>
                  <option value="">Seleccione</option>

              </select>
          </fieldset> -->

          <fieldset class="form-group col">
              <label for="for_fundament_manage_id">Seleccionar Tipo de Compra:</label>
              <select multiple class="form-control selectpicker" title="Seleccione..." id="for_fundament_manage_id" size="5" name="fundament_manage_id[]" required>
                @foreach($fundamentManages as $fundamentManage)
                  <option value="{{ $fundamentManage->id }}" {{-- @if($fundamentManages->contains($fundamentManage->id)) selected @endif --}}>{{ $fundamentManage->NameValue }}</option>
                @endforeach
              </select>
          <fieldset class="form-group col">

          <br>

          <button type="submit" class="btn btn-primary float-right">Guardar</button>
      </form>
    </div>
</div>

@endsection

@section('custom_js')

@endsection
