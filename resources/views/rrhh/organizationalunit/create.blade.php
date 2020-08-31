@extends('layouts.app')

@section('title', 'Crear Unidad Organizacional')

@section('content')

<h3>Crear nueva unidad organizacional</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.organizational-units.store') }}">
	{{ csrf_field() }}

	<fieldset class="form-group">
		<label for="forName">Nombre</label>
		<input type="text" class="form-control" id="forName" placeholder="Nombre de la unidad organizacional" name="name" required="required">
	</fieldset>

	<fieldset class="form-group">
		<label for="forFather">Depende de</label>
		<select class="custom-select" id="forFather" name="father">
			<option value="{{ $organizationalUnit->id }}">
            {{ $organizationalUnit->name }}
            </option>
            @foreach($organizationalUnit->childs as $child_level_1)
                <option value="{{ $child_level_1->id }}">
                &nbsp;&nbsp;&nbsp;
                {{ $child_level_1->name }}
                </option>
                @foreach($child_level_1->childs as $child_level_2)
                    <option value="{{ $child_level_2->id }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{ $child_level_2->name }}
                    </option>
                    @foreach($child_level_2->childs as $child_level_3)
                        <option value="{{ $child_level_3->id }}">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $child_level_3->name }}
                        </option>
                    @endforeach
                @endforeach
            @endforeach
		</select>
	</fieldset>

    <button type="submit" class="btn btn-primary">Crear</button>

    <a href="{{ route('rrhh.organizational-units.index') }}" class="btn btn-outline-dark">Cancelar</a>

</form>

@endsection
