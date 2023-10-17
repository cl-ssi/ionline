@extends('layouts.bt4.app')

@section('title', 'Crear nuevo Permisos')

@section('content')


<h3 class="mb-3">Editar Profesión</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.professions.update', $profession) }}">
    @csrf
    @method('PUT')

    <div class="form-row">

        <fieldset class="form-group col-6 col-md-4">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name" value="{{$profession->name}}" autocomplete="off" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_category">Categoría*</label>
            <select name="category" class="form-control" id="for_category" required>
                <option value=""></option>
                <option value="A" {{ ($profession->category == 'A')?'selected':'' }}>A (Médicos, Odontólogos, Farmacéuticos)</option>
                <option value="B" {{ ($profession->category == 'B')?'selected':'' }}>B (Profesionales)</option>
                <option value="C" {{ ($profession->category == 'C')?'selected':'' }}>C (Técnicos Nivel Superior)</option>
                <option value="D" {{ ($profession->category == 'D')?'selected':'' }}>D (Técnicos Nivel Medio)</option>
                <option value="E" {{ ($profession->category == 'E')?'selected':'' }}>E (Administrativo)</option>
                <option value="F" {{ ($profession->category == 'F')?'selected':'' }}>F (Auxiliar, Chofer)</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_estamento">Estamento*</label>
            <select name="estamento" class="form-control" id="for_estamento" required>
                <option value=""></option>
                <option value="Ley 19.664" {{ ($profession->estamento == 'F')?'selected':'' }}>Ley 19.664 Médico/Farmacéutico/Odontólogo</option>
                <option value="Profesional" {{ ($profession->estamento == 'Profesional')?'selected':'' }}>Profesional</option>
                <option value="Técnico" {{ ($profession->estamento == 'Técnico')?'selected':'' }}>Técnico</option>
                <option value="Administrativo" {{ ($profession->estamento == 'Administrativo')?'selected':'' }}>Administrativo</option>
                <option value="Auxiliar" {{ ($profession->estamento == 'Auxiliar')?'selected':'' }}>Auxiliar</option>
            </select>
        </fieldset>

    </div>

    <div class="form-row">

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_name">Planta (SIRH)*</label>
            <input type="text" class="form-control" id="for_sirh_plant" value="{{$profession->sirh_plant}}" name="sirh_plant" required>
        </fieldset>

        <!-- <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Función (SIRH)*</label>
            <input type="text" class="form-control" id="for_sirh_function" value="{{$profession->sirh_function}}" name="sirh_function" required>
        </fieldset> -->

        <fieldset class="form-group col-12 col-md-6">
            <label for="for_name">Profesión (SIRH)*</label>
            <input type="text" class="form-control" id="for_sirh_profession" value="{{$profession->sirh_profession}}" name="sirh_profession" required>
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.professions.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
