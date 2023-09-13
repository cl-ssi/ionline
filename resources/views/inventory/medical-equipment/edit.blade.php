@extends('layouts.app')

@section('title', 'Editar Computador')

@section('content')

    <h3>Editar Equipo Medico</h3>

    <br>

    <form method="POST" class="form-horizontal" action="{{ route('medical-equipment.update', $equipment) }}">
        @method('PUT')
        @csrf

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="forClinicalService">Servicio Clinico</label>
                <input type="text" class="form-control" id="forClinicalService" placeholder="Servicio Clinico"
                    name="clinical_service" required="required" value="{{ $equipment->clinical_service }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forPrecint">Recinto</label>
                <input type="text" class="form-control" id="forPrecint" placeholder="Recinto" name="precint"
                    value="{{ $equipment->precint }}">
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="forClass">Clase</label>
                <input type="text" class="form-control" id="forClass" placeholder="Clase" name="class"
                    required="required" value="{{ $equipment->class }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forSubclass">Subclase</label>
                <select name="subclass" id="forSubclass" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="alto-costo" {{ $equipment->subclass == 'alto-costo' ? 'selected' : '' }}>Alto Costo
                    </option>
                    <option value="mediano-costo" {{ $equipment->subclass == 'mediano-costo' ? 'selected' : '' }}>Mediano
                        Costo</option>
                    <option value="bajo-costo" {{ $equipment->subclass == 'bajo-costo' ? 'selected' : '' }}>Bajo Costo
                    </option>
                </select>
            </fieldset>

            <fieldset class="form-group col-6">
                <label for="forEquipmentName">Nombre Equipo</label>
                <input type="text" class="form-control" id="forEquipmentName" placeholder="Nombre Equipo"
                    name="equipmentName" required="required" value="{{ $equipment->equipment_name }}">
            </fieldset>

        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="forBrand">Marca</label>
                <input type="text" class="form-control" id="forBrand" placeholder="Marca" name="brand"
                    required="required" value="{{ $equipment->brand }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forModel">Modelo</label>
                <input type="text" class="form-control" id="forModel" placeholder="Modelo" name="model"
                    required="required" value="{{ $equipment->model }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forSerial">Serial</label>
                <input type="text" class="form-control" id="forSerial" placeholder="Serial" name="serial"
                    value="{{ $equipment->serial }}">
            </fieldset>

        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="forInventoryNumber">Numero Inventario</label>
                <input type="number" class="form-control" id="forInventoryNumber" placeholder="Numero Inventario"
                    name="inventoryNumber" required="required" value="{{ $equipment->inventory_number }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_adquisition_year">Año Adquisicion</label>
                <input type="number" class="form-control" id="for_adquisition_year" name="adquisition_year"
                    placeholder="Año Adquisicion" required="required" value="{{ $equipment->adquisition_year }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_lifespan">Vida Util</label>
                <input type="number" class="form-control" id="for_lifespan" name="lifespan" placeholder="Vida Util"
                    required="required" value="{{ $equipment->lifespan }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_remaining_lifespan">Vida Util Residual</label>
                <input type="number" class="form-control" id="for_remaining_lifespan" name="remaining_lifespan"
                    placeholder="Vida Util Residual" required="required" value="{{ $equipment->remaining_lifespan }}">
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="for_ownership">Dueño</label>
                <select class="form-control" id="for_ownership" name="ownership">
                    <option value="propio" {{ $equipment->ownership == 'propio' ? 'selected' : '' }}>Propio</option>
                    <option value="arrendado" {{ $equipment->ownership == 'arrendado' ? 'selected' : '' }}>Arrendado
                    </option>
                    <option value="comodato" {{ $equipment->ownership == 'comodato' ? 'selected' : '' }}>Comodato</option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_state">Estado</label>
                <select class="form-control" id="for-state" name="state">
                    <option value="bueno" {{ $equipment->state == 'bueno' ? 'selected' : '' }}>Bueno</option>
                    <option value="regular" {{ $equipment->state == 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="malo" {{ $equipment->state == 'malo' ? 'selected' : '' }}>Malo</option>
                    <option value="baja" {{ $equipment->state == 'propio' ? 'baja' : '' }}>Baja</option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_level">Nivel</label>
                <select class="form-control" id="for_level" name="level">
                    <option value="critico" {{ $equipment->level == 'critico' ? 'selected' : '' }}>Critico</option>
                    <option value="relevante" {{ $equipment->level == 'relevante' ? 'selected' : '' }}>Relevante</option>
                    <option value="mayor-igual-12" {{ $equipment->level == 'mayor-igual-12' ? 'selected' : '' }}>IM>12
                    </option>
                    <option value="no-aplica" {{ $equipment->level == 'no-aplica' ? 'selected' : '' }}>No Aplica</option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_under_warranty">Bajo Garantia</label>
                <select class="form-control" id="for_under_warranty" name="under_warranty">
                    <option value=true {{ $equipment->under_warranty == true ? 'selected' : '' }}>Si</option>
                    <option value=false {{ $equipment->under_warranty == false ? 'selected' : '' }}>No</option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_warranty_expiration_year">Año Vencimiento Garantia</label>
                <input type="number" class="form-control" id="for_warranty_expiration_year"
                    name="warranty_expiration_year" min="1900" value="{{ $equipment->warranty_expiration_year }}">
            </fieldset>
        </div>


        <fieldset class="form-group">
            <button type="submit" class="btn btn-primary">
                <span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

    </form>

    <a href="{{ route('medical-equipment.index') }}" class="btn btn-outline-dark">
        Cancelar
    </a>

    <form method="POST" action="{{ route('medical-equipment.destroy', $equipment) }}" class="d-inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger float-right">
            <span class="fas fa-trash" aria-hidden="true"></span> Eliminar
        </button>
    </form>

    </fieldset>
@endsection
