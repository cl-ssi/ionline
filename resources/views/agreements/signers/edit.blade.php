@extends('layouts.app')

@section('title', $signer->appellative)

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Firmante para cargo de {{$signer->appellative}}</h3>

<form method="POST" class="form-horizontal" action="{{ route('agreements.signers.update', $signer) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_rut">Cargo</label>
            <select name="appellative" class="form-control selectpicker" data-live-search="true" title="Seleccione..." required>
                @php($appellativeOptions = array('Director', 'Directora', 'Director (S)', 'Directora (S)'))
                @foreach($appellativeOptions as $option)
                <option value="{{$option}}" @if($signer->appellative == $option) selected @endif>{{$option}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_name">Nombre</label>
            <select name="user_id" class="form-control selectpicker" data-live-search="true" title="Seleccione..." required>
                @foreach($users as $user)
                <option value="{{$user->id}}" @if(isset($signer->user->id) && $user->id == $signer->user->id) selected @endif>{{$user->fullName}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_address">Decreto</label>
            <input type="text" class="form-control" id="decree" name="decree" value="{{$signer->decree}}" required>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary mb-4">Guardar</button>

</form>

@endsection