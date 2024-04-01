@extends('layouts.bt5.app')

@section('title', 'Editar Establecimiento')

@section('content')

<h3 class="mb-3">Editar Establecimiento</h3>

<form method="POST" action="{{ route('parameters.establishments.update', $establishment) }}">
    @csrf
    @method('PUT')

    <div class="form-group row g-2 mb-3">
        <div class="col-12 col-md-7">
            <label for="name">Nombre*</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $establishment->name }}" autocomplete="off" required>
        </div>
        <div class="col-12 col-md-2">
            <label for="alias">Alias</label>
            <input type="text" class="form-control" id="alias" name="alias" value="{{ $establishment->alias }}">
        </div>
        <div class="col-12 col-md-3">
            <label for="establishment_type_id">Tipo*</label>
            <select class="form-select" id="establishment_type_id" name="establishment_type_id" required>
                <option value="">Seleccione una opción</option>
                @foreach($establishmentTypes as $establishmentType)
                <option value="{{ $establishmentType->id }}" @if ($establishmentType->id == $establishment->establishment_type_id)
                    selected
                    @endif
                    >{{ $establishmentType->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row g-2 mb-3">
        <div class="col-12 col-md-12">
            <label for="official_name">Nombre oficial</label>
            <input type="text" class="form-control" id="official_name" name="official_name" value="{{ $establishment->official_name }}" autocomplete="off">
        </div>
    </div>

    <div class="form-group row g-2 mb-3">
        <div class="col-6 col-md">
            <label for="deis">DEIS</label>
            <input type="text" class="form-control" id="deis" name="deis" value="{{ $establishment->deis }}">
        </div>
        <div class="col-6 col-md">
            <label for="new_deis">Nuevo DEIS</label>
            <input type="number" class="form-control" id="new_deis" name="new_deis" required value="{{ $establishment->new_deis }}">
        </div>
        <div class="col-6 col-md">
            <label for="mother_code">Código Madre</label>
            <input type="text" class="form-control" id="mother_code" name="mother_code" value="{{ $establishment->mother_code }}">
        </div>
        <div class="col-6 col-md">
            <label for="new_mother_code">Nuevo Código Madre</label>
            <input type="text" class="form-control" id="new_mother_code" name="new_mother_code" value="{{ $establishment->new_mother_code}}">
        </div>
        <div class="col-6 col-md">
            <label for="sirh_code">Código SIRH</label>
            <input type="number" class="form-control" id="sirh_code" name="sirh_code" value="{{ $establishment->sirh_code }}" autocomplete="off">
        </div>
    </div>

    <div class="form-group row g-2 mb-3">

        <div class="col-12 col-md-3">
            <label for="dependency">Dependencia</label>
            <select class="form-select" id="commune_id" name="dependency" required>
                <option value="">Seleccione una opción</option>
                <option value="Servicio de Salud Tarapacá" @if ($establishment->dependency == 'Servicio de Salud Tarapacá')
                    selected
                    @endif
                    >Servicio de Salud Tarapacá</option>
                <option value="SEREMI De Tarapacá" @if ($establishment->dependency == 'SEREMI De Tarapacá')
                    selected
                    @endif
                    >SEREMI De Tarapacá</option>
                <option value="No Aplica" @if ($establishment->dependency == 'No Aplica')
                    selected
                    @endif
                    >No Aplica</option>
            </select>
        </div>


        <div class="col-12 col-md-3">
            <label for="health_services_id">Servicios de salud</label>
            <select class="form-select" id="health_services_id" name="health_services_id" required>
                <option value="">Seleccione una opción</option>
                @foreach($healthServices as $healthService)
                <option value="{{ $healthService->id }}" @if ($healthService->id == $establishment->health_services_id)
                    selected
                    @endif
                    >{{ $healthService->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-3">
            <label for="administrative_dependency">Dependencia administrativa</label>
            <select class="form-select" id="administrative_dependency" name="administrative_dependency" required>
                <option value="Servicio de Salud" @if($establishment->administrative_dependency == "Servicio de Salud") selected @endif>Servicio de Salud</option>
                <option value="Municipal" @if($establishment->administrative_dependency == "Municipal") selected @endif>Municipal</option>
            </select>
        </div>


        <div class="col-12 col-md-3">
            <label for="level_of_care">Nivel de atención</label>
            <select class="form-select" id="level_of_care" name="level_of_care" required>
                <option value="Primario" @if($establishment->level_of_care == "Primario") selected @endif>Primario</option>
                <option value="Secundario" @if($establishment->level_of_care == "Secundario") selected @endif>Secundario</option>
                <option value="Terciario" @if($establishment->level_of_care == "Terciario") selected @endif>Terciario</option>
                <option value="No Aplica" @if($establishment->level_of_care == "No Aplica") selected @endif>No Aplica</option>
            </select>
        </div>
    </div>

    <div class="form-group row g-2 mb-3">
        <div class="col-3 col-md-3">
            <label for="street_type">Tipo de calle*</label>
            <select class="form-select" id="street_type" name="street_type" required>
                <option value="Avenida" @if($establishment->street_type == "Avenida") selected @endif>Avenida</option>
                <option value="Calle" @if($establishment->street_type == "Calle") selected @endif>Calle</option>
                <option value="Pasaje" @if($establishment->street_type == "Pasaje") selected @endif>Pasaje</option>
            </select>
        </div>

        <div class="col-6 col-md-6">
            <label for="address">Dirección*</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $establishment->address }}" required>
        </div>

        <div class="col-3 col-md-3">
            <label for="street_number">Número de calle*</label>
            <input type="text" class="form-control" id="street_number" name="street_number" value="{{ $establishment->street_number }}" required>
        </div>
    </div>

    <div class="form-group row g-2 mb-3">
        <div class="col-4 col-md-3">
            <label for="commune_id">Comuna</label>
            <select class="form-select" id="commune_id" name="commune_id" required>
                <option value="">Seleccione una opción</option>
                @foreach($communes as $commune)
                <option value="{{ $commune->id }}" @if ($commune->id == $establishment->commune_id)
                    selected
                    @endif
                    >{{ $commune->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-6 col-md-3">
            <label for="latitude">Latitud</label>
            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $establishment->latitude }}">
        </div>

        <div class="col-6 col-md-3">
            <label for="longitude">Longitud</label>
            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $establishment->longitude }}">
        </div>
        <div class="col-3 col-md-3">
            <label for="telephone">Teléfono</label>
            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $establishment->telephone }}" required>
        </div>
    </div>

    <div class="form-group row g-2 mb-3">

        <div class="col-4 col-md-4">
            <label for="level_of_complexity">Nivel de Complejidad</label>
            <select class="form-select" id="level_of_complexity" name="level_of_complexity" required>
                <option value="">Seleccione una opción</option>
                <option value="Alta Complejidad" @if($establishment->level_of_complexity == "Alta Complejidad") selected @endif>Alta Complejidad</option>
                <option value="Mediana Complejidad" @if($establishment->level_of_complexity == "Mediana Complejidad") selected @endif>Mediana Complejidad</option>
                <option value="Baja Complejidad" @if($establishment->level_of_complexity == "Baja Complejidad") selected @endif>Baja Complejidad</option>
                <option value="No Aplica" @if($establishment->level_of_complexity == "No Aplica") selected @endif>No Aplica</option>
            </select>
        </div>

        <div class="col-3 col-md-3">
            <label for="provider_type_health_system">Tipo de Prestador</label>
            <select class="form-select" id="provider_type_health_system" name="provider_type_health_system" required>
                <option value="">Seleccione una opción</option>
                <option value="Público" @if($establishment->provider_type_health_system == "Público") selected @endif>Público</option>
                <option value="Privado" @if($establishment->provider_type_health_system == "Privado") selected @endif>Privado</option>
                <option value="Fuerzas Armadas y de Orden" @if($establishment->provider_type_health_system == "Fuerzas Armadas y de Orden") selected @endif>Fuerzas Armadas y de Orden</option>
            </select>
        </div>

        <div class="col-2 col-md-2">
            <label for="emergency_service">Serv de Urgencia</label>
            <select class="form-select" id="emergency_service" name="emergency_service" required>
                <option value="">Seleccione una opción</option>
                <option value="SI" @if($establishment->emergency_service == "SI") selected @endif>SI</option>
                <option value="NO" @if($establishment->emergency_service == "NO") selected @endif>NO</option>
            </select>
        </div>
    </div>

    <div class="form-row row g-2 mb-3">
        <div class="form-group col-12 col-md-12">
            <label for="mail_director">Mail Director (Opcional)</label>
            <input type="text" class="form-control" id="mail_director" name="mail_director" value="{{$establishment->mail_director}}" placeholder="ingresar mail de director, en caso de ser mas campos separarlo por coma ej: director.ssi@redsalud.gob.cl, director.ssi@redsalud.gov.cl" >
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('parameters.establishments.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection