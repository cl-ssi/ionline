@extends('layouts.app')

@section('content')
@canany(['be god','Rem: admin','Rem: user'])
@include('rem.nav')
@endcan

<form method="POST" class="form-horizontal" action="{{ route('rem.users.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_establishment_id">Establecimiento</label>
            <select name="establishment_id" id="for_establishment_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Establecimiento" required>
                <option value="">Seleccionar Establecimiento</option> 
                @foreach($establishments as $establishment)
                <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
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