@extends('layouts.app')

@section('title', 'Directorio Telefónico')

@section('content')

<div class="clearfix">

	<div class="float-left"><h3>Directorio Telefónico</h3></div>

	<div class="float-right">
		<form class="form-inline" method="GET" action="{{ route('rrhh.users.directory') }}">
			<div class="input-group mb-3">
				<input type="text" name="name" class="form-control" placeholder="Nombre o Apellido">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="submit">
						<i class="fas fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
		</form>
	</div>

</div>

<div class="row">
	<div class="col-md-7">
		<b>+</b> <a href="{{ route('rrhh.users.directory') }}?ou={{$organizationalUnit->id}}">{{ $organizationalUnit->name }}</a>
		<ul class="small">
			@foreach($organizationalUnit->childs as $child_level_1)
				<li><a href="{{ route('rrhh.users.directory') }}?ou={{$child_level_1->id}}"> {{$child_level_1->name}} </a></li>
				<ul>
					@foreach($child_level_1->childs as $child_level_2)
						<li><a href="{{ route('rrhh.users.directory') }}?ou={{$child_level_2->id}}">{{ $child_level_2->name }}</a></li>
							<ul>
								@foreach($child_level_2->childs as $child_level_3)
									<li><a href="{{ route('rrhh.users.directory') }}?ou={{$child_level_3->id}}">{{ $child_level_3->name }}</a></li>
								@endforeach
							</ul>
					@endforeach
				</ul>
			@endforeach
		</ul>
	</div>


	<div class="col-md-5">
		@foreach($users as $user)
		<address class="border border p-1">
			<strong>{{ $user->name }} {{ $user->fathers_family }} {{ $user->mothers_family }}</strong>
			<br>

			@if($user->position OR $user->organizationalunit)
			<small class="text-muted">
				@if($user->position == 'Jefe' OR
					$user->position == 'Director' OR
					$user->position == 'Jefa' OR
					$user->position == 'Directora')
						{{ $user->position }}
				@elseif($user->position != NULL)
					<em>{{ $user->position }} - </em>
				@endif

				{{ optional($user->organizationalunit)->name }}

			</small>
			<br>
			@endif

			<small>{{ env('APP_SS') }}</small><br>

			@if($user->email)
			<a href="mailto:{{ $user->email }}"><i class="fas fa-envelope"></i> {{ $user->email }}</a>
			<br>
			@endif

			<a href="tel:+56{{ $user->telephones[0]->number }}"><i class="fas fa-phone"></i>
				<abbr title="Teléfono"> {{ $user->telephones->first()->number }} </abbr>
			</a> - <i class="fas fa-phone-square"></i>
				<abbr title="Anexo Minsal">{{ $user->telephones->first()->minsal }}</abbr>

		</address>
		@endforeach
		{{ $users->render() }}
	</div>

</div>


@endsection
