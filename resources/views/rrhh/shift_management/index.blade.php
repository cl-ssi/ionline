@extends('layouts.app')
@section('title', 'Gestion de Turnos')
@section('content')

<div class="row">
	
	<div class="col-md-2">
		@foreach($users as $user)	
			<tr>
				<th scope="row" nowrap>{{ $user->runFormat() }}</td>
				<td nowrap>{{ $user->name }} {{ $user->fathers_family }} {{ $user->mothers_family }}</td>
				<td nowrap> TURNO A </td>
			</th>				

		@endforeach

	</div>
	<div class="col-md-5">
	</div>
	<div class="col-md-5">
	</div>
</div>
@endsection

