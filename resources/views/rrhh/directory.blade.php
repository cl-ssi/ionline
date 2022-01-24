@extends('layouts.app')

@section('title', 'Directorio Telefónico')

@section('content')

<style>
	.raya.rojo {
		color: #EE3A43;
		display: inline-block;
		font-family: 'Helvetica', sans-serif;
		font-size: 24px;
	}
	.raya.azul {
		color: #0168B3;
		display: inline-block;
		font-family: 'Helvetica', sans-serif;
		font-size: 24px;
	}
}
</style>

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
	<div class="col-md-6">
		<b>+</b> <a href="{{ route('rrhh.users.directory') }}?ou={{$organizationalUnit->id}}">{{ $organizationalUnit->name }}</a>
		<ul class="small">
			@foreach($organizationalUnit->childs as $child_level_1)
				@if($child_level_1->name != 'Externos')
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
				@endif
			@endforeach
		</ul>
	</div>


	<div class="col-md-6">
		@foreach($users as $user)

		<address class="border p-2 mb-3">
			<span class="raya azul">━━━━━</span><span class="raya rojo">━━━━━━━━</span><br>
			<strong>{{ $user->name }} {{ $user->fathers_family }} {{ $user->mothers_family }}</strong>

			@if($user->position)
				<span class="text-muted">
					<br>
					@if($user->position == 'Jefe' OR
						$user->position == 'Director' OR
						$user->position == 'Jefa' OR
						$user->position == 'Directora')
							{{ $user->position }}
					@elseif($user->position != NULL)
						<em>{{ $user->position }}</em>
					@endif
				</span>
			@endif
			
			@if($user->organizationalunit)
				<br>
				{{ $user->organizationalunit->name }}
			@endif


			@foreach($user->telephones as $telephone)
				<br>
				Teléfono: <a href="tel:+56{{ $telephone->number }}">+56 {{ $telephone->number }}</a> /  
				Anexo: {{ $telephone->minsal }}
			@endforeach

			@if($user->email)
				<br>
				<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
			@endif

			<br>
			<strong class="text-muted"><br>{{ env('APP_SS') }}<br>Gobierno de Chile</strong>

		</address>
		@endforeach

		@if($users->isNotEmpty())
			{{ $users->render() }}
		@endif
	</div>

</div>


@endsection
