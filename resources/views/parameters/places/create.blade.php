<form method="POST" class="form-horizontal" action="{{ route('parameters.places.store') }}">
    @csrf

    <div class="form-row g-2">
        <fieldset class="form-group col-md-4 col-sm-12">
            <label for="for_name">Nombre*</label>
            <input
                type="text"
                class="form-control"
                id="for_name"
                placeholder="Ej. Oficina 211"
                name="name"
                required
            >
        </fieldset>

        <fieldset class="form-group col-md-4 col-sm-12">
            <label for="for_description">Descripción</label>
            <input
                type="text"
                class="form-control"
                id="for_description"
                placeholder="Opcional"
                name="description"
            >
        </fieldset>

        <fieldset class="form-group col-md-4 col-sm-12">
            <label for="for_location_id">Edificio</label>
            <select
                name="location_id"
                id="for_location_id"
                class="form-control"
                required
            >
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.places.index') }}">Volver</a>

</form>
