@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

@include('rrhh.users_service_requests.submenu')

@can('Users: edit')
<form method="POST" class="form-horizontal" action="{{ route('rrhh.users.service_requests.update',$user->id) }}">
	@csrf
    @method('PUT')

	<div class="form-row">
		<div class="form-group col-md-2">
			<label for="run">RUN</label>
			<input type="text" readonly class="form-control-plaintext" id="staticRUN" value="{{$user->runFormat()}}">
		</div>
		<div class="form-group col-md-4">
			<label for="name">Nombres</label>
			<input type="text" class="form-control" name="name" value="{{$user->name}}">
		</div>
		<div class="form-group col-md-2">
			<label for="name">Apellido Paterno</label>
			<input type="text" class="form-control" name="fathers_family" value="{{ $user->fathers_family }}">
		</div>
		<div class="form-group col-md-2">
			<label for="name">Apellido Materno</label>
			<input type="text" class="form-control" name="mothers_family" value="{{ $user->mothers_family }}">
		</div>

		<fieldset class="form-group col-md-2">
			<label for="forbirthday">Fecha Nacimiento</label>
			<input type="date" class="form-control" id="forbirthday"
				name="birthday" value="{{ $user->birthday ? $user->birthday->format('Y-m-d'):'' }}">
		</fieldset>

	</div>

	<div class="form-row">
		<div class="form-group col">
			<label for="email">Correo</label>
			<input type="email" class="form-control" name="email" value="{{$user->email}}">
		</div>
		<div class="form-group col">
			<label for="email">Correo Personal</label>
			<input type="email" class="form-control" name="email_personal" value="{{$user->email_personal}}">
		</div>
	</div>

	<div class="form-row">
		<fieldset class="form-group col-md-4">
			<label for="forPosition">Cargo/Funcion</label>
			<input type="text" class="form-control" id="forPosition" placeholder="Cargo/Funcion" name="position"
			value="{{ $user->position }}">
		</fieldset>

		<fieldset class="form-group col-md-8">
			<label for="forOrganizationalUnit">Unidad Organizacional</label>
			<select class="custom-select" id="forOrganizationalUnit" name="organizationalunit">
				<option value="{{ $ouRoot->id }}" {{ ($user->organizationalunit == $ouRoot)?'selected':''}}>
				{{ $ouRoot->name }}
				</option>
				@foreach($ouRoot->childs as $child_level_1)
					<option value="{{ $child_level_1->id }}" {{ ($user->organizationalunit == $child_level_1)?'selected':''}}>
					&nbsp;&nbsp;&nbsp;
					{{ $child_level_1->name }}
					</option>
					@foreach($child_level_1->childs as $child_level_2)
						<option value="{{ $child_level_2->id }}" {{ ($user->organizationalunit == $child_level_2)?'selected':''}}>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						{{ $child_level_2->name }}
						</option>
						@foreach($child_level_2->childs as $child_level_3)
							<option value="{{ $child_level_3->id }}" {{ ($user->organizationalunit == $child_level_3)?'selected':''}}>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								{{ $child_level_3->name }}
							</option>
						@endforeach
					@endforeach
				@endforeach

			</select>
		</fieldset>
	</div>

	<div class="form-group d-inline">
		<button type="submit" class="btn btn-sm btn-primary">
		<span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

		</form>

		<form method="POST" action="{{ route('rrhh.users.password.reset', $user->id) }}" class="d-inline">
			{{ method_field('PUT') }} {{ csrf_field() }}
			<button class="btn btn-sm btn-outline-secondary"><span class="fas fa-redo" aria-hidden="true"></span> Restaurar clave</button>
		</form>

		@can('Users: delete')
		<form method="POST" action="{{ route('rrhh.users.destroy', $user->id) }}" class="d-inline">
			{{ method_field('DELETE') }} {{ csrf_field() }}
			<button class="btn btn-sm btn-danger"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>
		@endcan

		<!-- @role('god')
		<form method="GET" action="{{ route('rrhh.users.switch', $user->id) }}" class="d-inline float-right">
			{{ csrf_field() }}
			<button class="btn btn-sm btn-outline-warning"><span class="fas fa-redo" aria-hidden="true"></span> Switch</button>
		</form>
		@endrole -->

	</div>

@endcan

@endsection
