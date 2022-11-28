@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

<br>

<h5><i class="fas fa-id-badge"></i> Nuevo Perfil de Cargo</h5>

<br>

<form method="POST" class="form-horizontal" action="{{-- route('replacement_staff.request.store') --}}" enctype="multipart/form-data"/>
    @csrf
    @method('POST')

    <h6 class="small"><b>I.IDENTIFICACIÓN DEL CARGO </b></h6> <br>
    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_name">Nombre de Cargo</label>
            <input type="text" class="form-control" name="name" id="for_name" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_charges_number">Nº Cargos</label>
            <input type="number" class="form-control" name="charges_number" id="for_charges_number">
        </fieldset>
        
        <fieldset class="form-group col-12 col-md-2">
            <label for="for_charges_number">Estamento</label>
            <select name="profile_manage_id" id="for_profile_manage_id" class="form-control" wire:model="selectedProfile" required>
                <option value="">Seleccione...</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>

</form>

@endsection

@section('custom_js')

@endsection
