@extends('layouts.app')

@section('title', 'Crear nuevo Permisos')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Editar Profesión</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.professions.update', $profession) }}">
    @csrf
    @method('PUT')

    <div class="form-row">

    <fieldset class="form-group col-6 col-md-4">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name" value="{{$profession->name}}" autocomplete="off" required>
        </fieldset>        

        <fieldset class="form-group col-12 col-md-3">
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
    

    <button type="submit" class="btn btn-primary">Actualizar</button>

</form>

@endsection

@section('custom_js')

@endsection
