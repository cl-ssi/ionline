@extends('layouts.bt4.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-cog"></i> Mantenedor de Fundamentos de Contratación.</h5>

<br>

<div class="row">
    <div class="col-sm-6">
      <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.manage.fundament.assign_fundament', $rstFundamentManage) }}">
          @csrf
          @method('POST')
          <fieldset class="form-group col">
              <label for="for_name">Calidad Jurídica</label>
                  <input type="text" class="form-control" name="name" value="{{ $rstFundamentManage->NameValue }}" readonly>
          </fieldset>
          <!-- <fieldset class="form-group col mt">
              <label for="for_profile_manage_id">Estamento</label>
              <select name="profile_manage_id" class="form-control" wire:model.live="profileSelected" required>
                  <option value="">Seleccione</option>

              </select>
          </fieldset> -->

          <fieldset class="form-group col">
              <label for="for_fundament_detail_id"></label>
              <select multiple class="form-control selectpicker" title="Seleccione..." id="for_fundament_detail_id" size="5" name="fundament_detail_id[]" required>
                @foreach($fundamentDetailManages as $fundamentDetailManage)
                  <option value="{{ $fundamentDetailManage->id }}" {{-- @if($fundamentManages->contains($fundamentManage->id)) selected @endif --}}>{{ $fundamentDetailManage->NameValue }}</option>
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
