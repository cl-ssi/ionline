@extends('layouts.bt4.app')

@section('title', 'Crear Establecimiento')

@section('content')

<h3 class="mb-3">Crear Establecimiento</h3>

<form method="POST" action="{{ route('parameters.establishments.store') }}">
    @csrf

    <div class="form-row">
        <div class="form-group col-9 col-md-9">
            <label for="name">Nombre*</label>
            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
        </div>
        <div class="form-group col-3 col-md-3">
            <label for="alias">Alias</label>
            <input type="text" class="form-control" id="alias" name="alias">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-4 col-md-4">
            <label for="establishment_type_id">Tipo de establecimiento*</label>
            <select class="form-control" id="establishment_type_id" name="establishment_type_id" required>
                <option value="">Seleccione una opción</option>
                @foreach($establishmentTypes as $establishmentType)
                <option value="{{ $establishmentType->id }}">{{ $establishmentType->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-4 col-md-4">
            <label for="deis">DEIS</label>
            <input type="text" class="form-control" id="deis" name="deis">
        </div>

        <div class="form-group col-4 col-md-4">
            <label for="new_deis">Nuevo DEIS</label>
            <input type="number" class="form-control" id="new_deis" name="new_deis" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-4 col-md-4">
            <label for="mother_code">Código Madre</label>
            <input type="text" class="form-control" id="mother_code" name="mother_code">
        </div>

        <div class="form-group col-4 col-md-4">
            <label for="new_mother_code">Nuevo Código Madre</label>
            <input type="text" class="form-control" id="new_mother_code" name="new_mother_code">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-2 col-md-2">
            <label for="sirh_code">Código SIRH</label>
            <input type="number" class="form-control" id="sirh_code" name="sirh_code" autocomplete="off">
        </div>

        <div class="form-group col-4 col-md-4">
            <label for="commune_id">Comuna</label>
            <select class="form-control" id="commune_id" name="commune_id" required>
                <option value="">Seleccione una opción</option>
                @foreach($communes as $commune)
                <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-3 col-md-3">
            <label for="dependency">Dependencia</label>
            <select class="form-control" id="commune_id" name="dependency" required>
                <option value="">Seleccione una opción</option>
                <option value="Servicio de Salud Tarapacá">Servicio de Salud Tarapacá</option>
                <option value="SEREMI De Tarapacá">SEREMI De Tarapacá</option>
                <option value="No Aplica">No Aplica</option>
            </select>
        </div>


        <div class="col-3 col-md-3">
            <label for="health_services_id">Servicios de salud</label>
            <select class="form-control" id="health_services_id" name="health_services_id" required>
                <option value="">Seleccione una opción</option>
                @foreach($healthServices as $healthService)
                <option value="{{ $healthService->id }}">{{ $healthService->name }}</option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="form-row">
        <div class="form-group col-12 col-md-12">
            <label for="official_name">Nombre oficial</label>
            <input type="text" class="form-control" id="official_name" name="official_name" autocomplete="off">
        </div>
    </div>


    <div class="form-row">
        <div class="form-group col-6 col-md-6">
            <label for="administrative_dependency">Dependencia administrativa</label>
            <select class="form-control" id="administrative_dependency" name="administrative_dependency" required>
                <option value="">Seleccione una opción</option>
                <option value="Servicio de Salud">Servicio de Salud</option>
                <option value="Municipal">Municipal</option>
            </select>
        </div>

        <div class="form-group col-6 col-md-6">
            <label for="level_of_care">Nivel de atención</label>
            <select class="form-control" id="level_of_care" name="level_of_care" required>
                <option value="">Seleccione una opción</option>
                <option value="Primario">Primario</option>
                <option value="Secundario">Secundario</option>
                <option value="Terciario">Terciario</option>
                <option value="No Aplica">No Aplica</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-3 col-md-3">
            <label for="street_type">Tipo de calle*</label>
            <select class="form-control" id="street_type" name="street_type" required>
                <option value="">Seleccione una opción</option>
                <option value="Avenida">Avenida</option>
                <option value="Calle">Calle</option>
                <option value="Pasaje">Pasaje</option>
            </select>
        </div>

        <div class="form-group col-6 col-md-6">
            <label for="address">Dirección*</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>

        <div class="form-group col-3 col-md-3">
            <label for="street_number">Número de calle*</label>
            <input type="text" class="form-control" id="street_number" name="street_number" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-6 col-md-6">
            <label for="latitude">Latitud</label>
            <input type="text" class="form-control" id="latitude" name="latitude">
        </div>

        <div class="form-group col-6 col-md-6">
            <label for="longitude">Longitud</label>
            <input type="text" class="form-control" id="longitude" name="longitude">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-3 col-md-3">
            <label for="telephone">Teléfono</label>
            <input type="text" class="form-control" id="telephone" name="telephone">
        </div>

        <div class="form-group col-4 col-md-4">
            <label for="level_of_complexity">Nivel de Complejidad</label>
            <select class="form-control" id="level_of_complexity" name="level_of_complexity" required>
                <option value="">Seleccione una opción</option>
                <option value="Alta Complejidad">Alta Complejidad</option>
                <option value="Mediana Complejidad">Mediana Complejidad</option>
                <option value="Baja Complejidad">Baja Complejidad</option>
                <option value="No Aplica">No Aplica</option>
            </select>
        </div>

        <div class="form-group col-3 col-md-3">
            <label for="provider_type_health_system">Tipo de Prestador</label>
            <select class="form-control" id="provider_type_health_system" name="provider_type_health_system" required>
                <option value="">Seleccione una opción</option>
                <option value="Público">Público</option>
                <option value="Privado">Privado</option>
                <option value="Fuerzas Armadas y de Orden">Fuerzas Armadas y de Orden</option>
            </select>
        </div>

        <div class="form-group col-2 col-md-2">
            <label for="emergency_service">Serv de Urgencia</label>
            <select class="form-control" id="emergency_service" name="emergency_service" required>
                <option value="">Seleccione una opción</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-12 col-md-12">
            <label for="mail_director">Mail Director (Opcional)</label>
            <input type="text" class="form-control" id="mail_director" name="mail_director" placeholder="ingresar mail de director, en caso de ser mas campos separarlo por coma ej: director.ssi@redsalud.gob.cl, director.ssi@redsalud.gov.cl" >
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Crear Establecimiento</button>
    <a href="{{ route('parameters.establishments.index') }}" class="btn btn-secondary ml-4">Cancelar</a>
</form>
@endsection