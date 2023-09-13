@extends('layouts.app')

@section('title', 'Crear Equipo Medico')

@section('content')

    <h3 class="mb-3">Crear Equipo Medico</h3>

    <form method="POST" class="form-horizontal" action="{{ route('medical-equipment.store') }}">
        @csrf

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="forClinicalService">Servicio Clinico</label>
                <input type="text" class="form-control" id="forClinicalService" placeholder="Servicio Clinico"
                    name="clinical_service" required="required">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forPrecint">Recinto</label>
                <input type="text" class="form-control" id="forPrecint" placeholder="Recinto" name="precint">
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="forClass">Clase</label>
                <input type="text" class="form-control" id="forClass" placeholder="Clase" name="class"
                    required="required">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forSubclass">Subclase</label>
                <select name="subclass" id="forSubclass" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="alto-costo">Alto Costo</option>
                    <option value="mediano-costo">Mediano Costo</option>
                    <option value="bajo-costo">Bajo Costo</option>
                </select>
            </fieldset>

            <fieldset class="form-group col-6">
                <label for="forEquipmentName">Nombre Equipo</label>
                <input type="text" class="form-control" id="forEquipmentName" placeholder="Nombre Equipo"
                    name="equipmentName" required="required">
            </fieldset>

        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="forBrand">Marca</label>
                <input type="text" class="form-control" id="forBrand" placeholder="Marca" name="brand"
                    required="required">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forModel">Modelo</label>
                <input type="text" class="form-control" id="forModel" placeholder="Modelo" name="model"
                    required="required">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forSerial">Serial</label>
                <input type="text" class="form-control" id="forSerial" placeholder="Serial" name="serial">
            </fieldset>

        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="forInventoryNumber">Numero Inventario</label>
                <input type="number" class="form-control" id="forInventoryNumber" placeholder="Numero Inventario"
                    name="inventoryNumber" required="required">
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_adquisition_year">Año Adquisicion</label>
                <input type="number" class="form-control" id="for_adquisition_year" name="adquisition_year"
                    placeholder="Año Adquisicion" required="required">
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_lifespan">Vida Util</label>
                <input type="number" class="form-control" id="for_lifespan" name="lifespan" placeholder="Vida Util"
                    required="required">
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_remaining_lifespan">Vida Util Residual</label>
                <input type="number" class="form-control" id="for_remaining_lifespan" name="remaining_lifespan"
                    placeholder="Vida Util Residual" required="required">
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="for_ownership">Dueño</label>
                <select class="form-control" id="for_ownership" name="ownership">
                    <option value="propio">Propio</option>
                    <option value="arrendado">Arrendado</option>
                    <option value="comodato">Comodato</option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_state">Estado</label>
                <select class="form-control" id="for-state" name="state">
                    <option value="bueno">Bueno</option>
                    <option value="regular">Regular</option>
                    <option value="malo">Malo</option>
                    <option value="baja">Baja</option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_level">Nivel</label>
                <select class="form-control" id="for_level" name="level">
                    <option value="critico">Critico</option>
                    <option value="relevante">Relevante</option>
                    <option value="mayor-igual-12">IM>12</option>
                    <option value="no-aplica">No Aplica</option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_under_warranty">Bajo Garantia</label>
                <select class="form-control" id="for_under_warranty" name="under_warranty">
                    <option value=true>Si</option>
                    <option value=false>No</option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_warranty_expiration_year">Año Vencimiento Garantia</label>
                <input type="number" class="form-control" id="for_warranty_expiration_year"
                    name="warranty_expiration_year" min="1900">
            </fieldset>
        </div>

        <button type="submit" class="btn btn-primary">Crear</button>

        <a href="{{ route('medical-equipment.index') }}" class="btn btn-outline-dark">Volver</a>

    </form>
@endsection