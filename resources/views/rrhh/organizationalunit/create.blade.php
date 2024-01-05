@extends('layouts.bt5.app')

@section('title', 'Crear Unidad Organizacional')

@section('content')

    @can('OrganizationalUnits: create')
        <h3>Crear nueva unidad organizacional</h3>

        <form method="POST"
            class="form-horizontal"
            action="{{ route('rrhh.organizational-units.store') }}">
            @csrf

            <div class="row mb-3">
                <fieldset class="form-group col-12">
                    <label for="forName">Nombre</label>
                    <input type="text"
                        class="form-control"
                        id="forName"
                        placeholder="Nombre de la unidad organizacional"
                        name="name"
                        required="required"
                        value="{{ old('name') }}">
                </fieldset>
            </div>

            <div class="row mb-3">
                <fieldset class="form-group col-12">
                    <label for="forFather">Depende de</label>
                    @livewire('select-organizational-unit', [
                        'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                    ])
                </fieldset>
            </div>

            <div class="row mb-3">
                <fieldset class="form-group col-4">
                    <label for="forSirhFunction">Id Función (SIRH)</label>
                    <input type="number"
                        class="form-control"
                        id="forSirhFunction"
                        placeholder="Código SIRH de la función"
                        name="sirh_function"
                        value="{{ old('sirh_function') }}">
                </fieldset>

                <fieldset class="form-group col-4">
                    <label for="forSirhOuId">Id Unid.Org. (SIRH)</label>
                    <input type="number"
                        class="form-control"
                        id="forSirhOuId"
                        placeholder="Código SIRH de la unidad organizacional"
                        name="sirh_ou_id"
                        value="{{ old('sirh_ou_id') }}">
                </fieldset>

                <fieldset class="form-group col-4">
                    <label for="forSirhCostCenter">C.Costos (SIRH)</label>
                    <input type="number"
                        class="form-control"
                        id="forSirhCostCenter"
                        placeholder="Código SIRH de la unidad organizacional"
                        name="sirh_cost_center"
                        value="{{ old('sirh_cost_center') }}">
                </fieldset>
            </div>

            <button type="submit"
                class="btn btn-primary">Crear</button>

            <a href="{{ route('rrhh.organizational-units.index') }}"
                class="btn btn-outline-dark">Cancelar</a>

        </form>
    @endcan

@endsection
