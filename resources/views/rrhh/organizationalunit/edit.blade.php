@extends('layouts.bt4.app')

@section('title', 'Editar Unidad Organizacional')

@section('content')

<h3>Editar Unidad Organizacional del {{ auth()->user()->organizationalUnit->establishment->name }}</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.organizational-units.update',$organizationalUnit->id) }}">
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <input
        type="hidden"
        name="organizationalUnitId"
        value="{{ $organizationalUnit->id }}"
    >

    @cannot(['Service Request', 'Service Request: export sirh mantenedores'])
        <div class="form-row">
            <fieldset class="form-group col-1">
                <label for="forLevel">Nivel</label>
                <input
                    type="text"
                    class="form-control"
                    id="forLevel"
                    value="{{ $organizationalUnit->level }}"
                    disabled
                >
            </fieldset>
            <fieldset class="form-group col-11">
                <label for="forName">Nombre</label>
                <input
                    type="text"
                    class="form-control"
                    id="forName"
                    name="name"
                    value="{{ old('name', $organizationalUnit->name) }}"
                >
            </fieldset>
        </div>

        @if($organizationalUnit->level != 1)
        <div class="form-row">
            <fieldset class="form-group col-12">
                <label for="forFather">Depende de</label>
                @livewire('select-organizational-unit', [
                    'establishment_id' => optional($organizationalUnit->father)->establishment_id,
                    'organizational_unit_id' => optional($organizationalUnit->father)->id,
                    'readonlyEstablishment' => true,
                ])
            </fieldset>
        </div>
        @endif
    @else
        <div class="form-row">
            <fieldset class="form-group col-1">
                <label for="forLevel">Nivel</label>
                <input
                    type="text"
                    class="form-control"
                    id="forLevel"
                    value="{{ $organizationalUnit->level }}"
                    disabled
                >
            </fieldset>
            <fieldset class="form-group col-11">
                <label for="forName">Nombre</label>
                <input
                    type="text"
                    class="form-control"
                    id="forName"
                    name="name"
                    value="{{ $organizationalUnit->name }}"
                    readonly
                >
            </fieldset>
        </div>

        @if($organizationalUnit->level != 1)
        <div class="form-row">
            <fieldset class="form-group col-9">
                <label for="forFather">Depende de</label>
                @livewire('select-organizational-unit', [
                    'establishment_id' => optional($organizationalUnit->father)->establishment_id,
                    'organizational_unit_id' => optional($organizationalUnit->father)->id,
                    'readonlyEstablishment' => true,
                ])
            </fieldset>
        </div>
        @endif
    @endcan

    <div class="form-row">
        <fieldset class="form-group col-4">
            <label for="forSirhFunction">Id Función (SIRH)</label>
            <input
                type="number"
                class="form-control"
                id="forSirhFunction"
                name="sirh_function"
                value="{{ old('sirh_function', $organizationalUnit->sirh_function) }}"

            >
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="forSirhOuId">Id Unid.Org. (SIRH)</label>
            <input
                type="number"
                class="form-control"
                id="forSirhOuId"
                name="sirh_ou_id"
                value="{{ old('sirh_ou_id', $organizationalUnit->sirh_ou_id) }}"

            >
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="forSirhCostCenter">C.Costos (SIRH)</label>
            <input
                type="number"
                class="form-control"
                id="forSirhCostCenter"
                name="sirh_cost_center"
                value="{{ old('sirh_cost_center', $organizationalUnit->sirh_cost_center) }}"
            >
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12">
            <button type="submit" class="btn btn-primary">
                <span class="fas fa-save" aria-hidden="true"></span> Actualizar
            </button>

            </form>

            <a href="{{ route('rrhh.organizational-units.index') }}" class="btn btn-outline-dark">Cancelar</a>

            @if($organizationalUnit->users()->exists() OR $organizationalUnit->childs()->exists())
                <button class="btn btn-danger" title="No se puede eliminar la unidad, tiene usuarios o unidades dentro de ella" disabled>
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            @else
                @cannot(['Service Request', 'Service Request: export sirh mantenedores'])
                <form method="POST" action="{{ route('rrhh.organizational-units.destroy', $organizationalUnit->id) }}" class="d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                </form>
                @endcan
            @endif

        </fieldset>
    </div>

    @include('partials.audit', ['audits' => $organizationalUnit->audits()] )

@endsection
