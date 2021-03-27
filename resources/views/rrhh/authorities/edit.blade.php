@extends('layouts.app')

@section('title', 'Editar Autoridad')

@section('content')
<h3 class="mb-3">Editar Autoridad</h3>

@can('Authorities: manager')
<form method="POST" class="form-horizontal" action="{{ route('rrhh.authorities.update',$authority->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_organizational_unit_id">Unidad Organizacional</label>
            <select name="organizational_unit_id" id="for_organizational_unit_id" class="form-control" style="font-family:monospace; font-size: 15px;">
                <option value="{{ $ouTopLevel->id }}" {{ ($ouTopLevel->id == $authority->organizational_unit_id)?'selected':''}} >{{ $ouTopLevel->name }}</option>
                @foreach($ouTopLevel->childs as $child_level_1)
                    <option value="{{ $child_level_1->id }}" {{ ($child_level_1->id == $authority->organizational_unit_id)?'selected':''}}> - {{ $child_level_1->name }}</option>
                        @foreach($child_level_1->childs as $child_level_2)
                            <option value="{{ $child_level_2->id }}" {{ ($child_level_2->id == $authority->organizational_unit_id)?'selected':''}}> - - {{ $child_level_2->name }}</option>
                                @foreach($child_level_2->childs as $child_level_3)
                                    <option value="{{ $child_level_3->id }}" {{ ($child_level_3->id == $authority->organizational_unit_id)?'selected':''}}> - - - {{ $child_level_3->name }}</option>
                                @endforeach
                        @endforeach
                @endforeach
            </select>
        </fieldset>
    </div>

    <div class="row">
        <fieldset class="form-group col-4">
            <label for="for_user_id">Funcionario</label>
            <select name="user_id" id="for_user_id" class="form-control">
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ ($user->id == $authority->user_id)?'selected':''}}>{{ $user->fullName }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_from">Desde</label>
            <input type="date" class="form-control" id="for_from" name="from" required value="{{ $authority->from->format('Y-m-d') }}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_to">Hasta</label>
            <input type="date" class="form-control" id="for_to" name="to" required value="{{ $authority->to->format('Y-m-d') }}">
        </fieldset>


        <fieldset class="form-group col">
            <label for="for_position">Cargo</label>
            <select name="position" id="for_position" class="form-control" required>
                <option {{ ($authority->position == 'Director')?'selected':'' }}>Director</option>
                <option {{ ($authority->position == 'Directora')?'selected':'' }}>Directora</option>
                <option {{ ($authority->position == 'Director (S)')?'selected':'' }}>Director (S)</option>
                <option {{ ($authority->position == 'Directora (S)')?'selected':'' }}>Directora (S)</option>
                <option {{ ($authority->position == 'Subdirector')?'selected':'' }}>Subdirector</option>
                <option {{ ($authority->position == 'Subdirectora')?'selected':'' }}>Subdirectora</option>
                <option {{ ($authority->position == 'Subdirector (S)')?'selected':'' }}>Subdirector (S)</option>
                <option {{ ($authority->position == 'Subdirectora (S)')?'selected':'' }}>Subdirectora (S)</option>
                <option {{ ($authority->position == 'Jefe')?'selected':'' }}>Jefe</option>
                <option {{ ($authority->position == 'Jefa')?'selected':'' }}>Jefa</option>
                <option {{ ($authority->position == 'Jefe (S)')?'selected':'' }}>Jefe (S)</option>
                <option {{ ($authority->position == 'Jefa (S)')?'selected':'' }}>Jefa (S)</option>
                <option {{ ($authority->position == 'Encargado')?'selected':'' }}>Encargado</option>
                <option {{ ($authority->position == 'Encargada')?'selected':'' }}>Encargada</option>
                <option {{ ($authority->position == 'Encargado (S)')?'selected':'' }}>Encargado (S)</option>
                <option {{ ($authority->position == 'Encargada (S)')?'selected':'' }}>Encargada (S)</option>
                <option {{ ($authority->position == 'Secretario')?'selected':'' }}>Secretario</option>
                <option {{ ($authority->position == 'Secretaria')?'selected':'' }}>Secretaria</option>
                <option {{ ($authority->position == 'Secretario (S)')?'selected':'' }}>Secretario (S)</option>
                <option {{ ($authority->position == 'Secretaria (S)')?'selected':'' }}>Secretaria (S)</option>
            </select>
        </fieldset>


        <fieldset class="form-group col">
            <label for="for_type">Tipo</label>
            <select name="type" id="for_type" class="form-control">
                <option value="manager" {{ ($authority->type == 'manager')?'selected':'' }}>Encargado (Jefes)</option>
                <option value="delegate" {{ ($authority->type == 'delegate')?'selected':'' }}>Delegado (Igual acceso que el jefe)</option>
                <option value="secretary" {{ ($authority->type == 'secretary')?'selected':'' }}>Secretario/a</option>
            </select>
        </fieldset>

    </div>

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_decree">Decreto que autoriza al funcionario ejercer cargo</label>
            <input type="text" class="form-control" id="for_decree" name="decree" value="{{$authority->decree}}">
        </fieldset>
    </div>

    <fieldset class="form-group">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

		</form>

		<a href="{{ route('rrhh.authorities.index') }}" class="btn btn-outline-secondary">Cancelar</a>

		<form method="POST" action="{{ route('rrhh.authorities.destroy', $authority) }}" class="d-inline">
			@csrf
            @method('DELETE')
			<button class="btn btn-danger float-right"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>

	</fieldset>

</form>
@endcan

@endsection

@section('custom_js')

@endsection
