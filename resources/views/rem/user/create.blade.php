@extends('layouts.bt4.app')

@section('content')
@include('rem.nav')

<h3 class="mb-3">Asignar Usuarios a Establecimientos</h3>
<form method="POST" class="form-horizontal" action="{{ route('rem.users.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_establishment_id">Establecimiento</label>
            <select name="establishment_id[]" id="for_establishment_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Establecimiento" multiple required>
                <option value="">Seleccionar Establecimiento</option> 
                @foreach($establishments as $establishment)
                <option value="{{ $establishment->id }}">{{ $establishment->official_name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_user_id">Usuarios </label>            
                @livewire('search-select-user', ['required' => 'required'])            
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection