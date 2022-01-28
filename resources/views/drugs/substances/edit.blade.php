@extends('layouts.app')

@section('title', 'Crear Banda Ancha Movil')

@section('content')

@include('drugs.nav')

<h3>Editar Sustancia</h3>

<form method="POST" class="form-horizontal" action="{{ route('drugs.substances.update', $substance->id) }}">
    @method('PUT')
    @csrf

    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="for_presumend"
                name="presumed" aria-describedby="presumend_help"
                @if ($substance->presumed == "1") checked @endif>
            <label class="form-check-label" for="for_presumend">Sustancia Presunta</label>
            <small id="presumend_help" class="form-text text-muted">
                La sustancia presunta se utiliza en una recepción,
                de lo contrario es una sustancia determinada por el resultado de
                un laboratorio.</small>
        </div>
    </div>

    <fieldset class="form-group">
        <label for="forname">Nombre*</label>
        <input type="text" class="form-control" id="forname"
            placeholder="Ingrese el nombre de la sustancia" name="name"
            value="{{ $substance->name }}" required="">
    </fieldset>

    <fieldset class="form-group">
        <label for="forcategory">Rama*</label>
        <select class="form-control" id="forrama" name="rama">
            <option disabled value></option>
            <option @if ($substance->rama == "Alucinógenos") selected="selected" @endif value="Alucinógenos">Alucinógenos</option>
            <option @if ($substance->rama == "Estimulantes") selected="selected" @endif value="Estimulantes">Estimulantes</option>
            <option @if ($substance->rama == "Depresores") selected="selected" @endif value="Depresores">Depresores</option>
        </select>
    </fieldset>

    <fieldset class="form-group">
        <label for="forunit">Unidad*</label>
        <select class="form-control" id="forunit" name="unit">
            <option value="">Seleccione...</option>
            <option @if ($substance->unit == "Ampollas") selected="selected" @endif value="Ampollas">Ampollas</option>
            <option @if ($substance->unit == "Gramos") selected="selected" @endif value="Gramos">Gramos</option>
            <option @if ($substance->unit == "Mililitros") selected="selected" @endif value="Mililitros">Mililitros</option>
            <option @if ($substance->unit == "Unidades") selected="selected" @endif value="Unidades">Unidades</option>
        </select>
    </fieldset>

    <fieldset class="form-group">
        <label for="forlaboratory">Laboratorio</label>
        <select class="form-control" id="forlaboratory" name="laboratory">
            <option></option>
            <option @if ($substance->laboratory == "SEREMI") selected="selected" @endif value="SEREMI">SEREMI</option>
            <option @if ($substance->laboratory == "ISP") selected="selected" @endif value="ISP">ISP</option>
        </select>
    </fieldset>

    <!--
    <div class="form-group">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="forisp" name="isp" @if ($substance->isp == "1") checked @endif value="1">
          <label class="form-check-label" for="forisp">ISP</label>
        </div>
    </div>
    -->

    <div class="float-right">
        <a href="{{ route('drugs.substances.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    </div>

</form>

@endsection
