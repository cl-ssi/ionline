<h3>Crear nueva unidad organizacional</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.organizationalunits.update',$organizationalUnit) }}">
    @csrf
    @method('PUT')
    <fieldset class="form-group">
        <label for="forName">Nombre</label>
        <input type="text" class="form-control" id="forName" placeholder="Nombre de la unidad organizacional" name="name" required="required" value="{{$organizationalUnit->name }}">
    </fieldset>
    <fieldset class="form-group">
        <label for="forFather">Depende de</label>
        <select class="custom-select" id="forFather" name="organizational_unit_id">
            @foreach($organizationalUnits as $ou)
				<option value="{{ $ou->id }}" @if ($organizationalUnit->father == $ou) selected="selected" @endif>{{ $ou->name }}</option>
			@endforeach 
        </select>
    </fieldset>

    <button type="submit">Guardar</button>



</form>