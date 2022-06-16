@extends('layouts.app')

@section('title', 'Requerimientos')

@section('content')

@include('requirements.partials.nav')

<div class="alert alert-info" role="alert">
	Esta es una nueva bandeja para ver los requerimientos, es más rápida y 
	también permite cambiar a las bandeja de su jefatura.<br>
	Puede intercambiar en lado derecho de la tabla resumen entre los "pendientes" y "archivados" .
</div>

@livewire('requirements.filter',[$user])

<div class="row">

	<div class="col">
		<h3 class="mb-3">
		@if(request()->has('archived'))
			Archivados
		@else
			Pendientes por atender
		@endif
		</h3>
	</div>

	<div class="col">
		<ul class="nav justify-content-end">
			<li class="nav-item">
				<a class="nav-link {{ ($user->id == auth()->id())?'disabled':'' }}" 
					href="{{ route('requirements.inbox',auth()->user()) }}">
					{{ auth()->user()->tinnyName }}
				</a> 
			</li>
			@foreach($allowed_users as $allowed)
			<li class="nav-item">
				<a class="nav-link {{ ($user == $allowed)?'disabled':'' }}" 
					href="{{ route('requirements.inbox',$allowed) }}">
					{{ $allowed->tinnyName }}
				</a>
			</li>
			@endforeach
		</ul>
	</div>

</div>



<table class="table table-sm small table-bordered">
	<tr>
		<td class="alert-light text-center">Recibidos ({{ $counters['created'] }})</td>
        <td class="alert-warning text-center">Respondidos ({{ $counters['replyed'] }})</td>
        <td class="alert-primary text-center">Derivados ({{ $counters['derived'] }})</td>
        <td class="alert-success text-center">Cerrados ({{ $counters['closed'] }})</td>
		<td class="alert-light text-center">
			<a href="{{ route('requirements.inbox',$user) }}" class="btn-link {{ request()->has('archived') ? '':'disabled' }}">Pendientes</a>
		</td>
        <td class="alert-light text-center">
			<a href="{{ route('requirements.inbox',$user) }}?archived=true" class="btn-link {{ request()->has('archived') ? 'disabled':'' }}">Archivados ({{ $counters['archived'] }})</a>
		</td>
    </tr>
</table>


<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>N°</th>
            <th>Asunto</th>
            <th width="160">Creado</th>
            <th width="160">Ultimo evento</th>
            <th>Fecha límite</th>
            <td></td>
        </tr>
    </thead>
    <tbody>
		@foreach($requirements as $req)
			@if($req->events->where('to_user_id',$user->id)->count() == $req->ccEvents->where('to_user_id',$user->id)->count())
				<tr class="alert-secondary">
			@else
				@switch($req->status)
					@case('creado')
						@if($req->user_id == auth()->id())
							<tr class="alert-info">
						@else
							<tr class="alert-light">
						@endif
						@break
					@case('respondido') 
						<tr class="alert-warning"> 	@break
					@case('cerrado') 
						<tr class="alert-success"> @break
					@case('derivado') 
						<tr class="alert-primary"> @break
					@case('reabierto') 
						<tr class="alert-light"> @break
				@endswitch
			@endif

				<td>
					{{ $req->id }}
					<br>
					<a href="{{ route('requirements.show',$req->id) }}" class="btn btn-sm btn-outline-primary">
						<i class="fas fa-edit"></i>
					</a>
				</td>
				<td>
					{{ $req->subject }}
					<br>
                    @foreach($req->categories->where('user_id', auth()->id()) as $category)
                        <span class='badge badge-primary' style='background-color: #{{$category->color}};'>
							{{$category->name}}
						</span>
                    @endforeach

					@if($req->parte)
						<div>
							<small>
								Parte: <b>{{ $req->parte->origin}} - {{$req->parte->number}}</b>
							</small>
						</div>
					@endif
				</td>
				<td>
					<b>Creado por</b><br>
					{{ $req->events->first()->from_user->tinnyName }}<br>
					{{ $req->created_at->format('Y-m-d H:i') }}<br>
					{{ $req->created_at->diffForHumans() }}<br>
				</td>

				<td>
				@switch($req->status)
					@case('creado')
					@break

					@case('cerrado')
					<b>Cerrado por</b><br>
					{{ $req->events->last()->from_user->tinnyName }}<br>
					{{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
					@break

					@case('respondido')
					@case('reabierto')
					<b>{{ ucfirst($req->status) }} por</b><br>
					{{ $req->events->last()->from_user->tinnyName }}<br>
					{{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
					<b>para </b>{{ $req->events->last()->to_user->tinnyName }}
					@break


					@case('derivado')
					<b>{{ ucfirst($req->status) }} para</b><br>
					{{ $req->events->last()->to_user->tinnyName }}<br>
					{{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
					<b>de </b>{{ $req->events->last()->from_user->tinnyName }}
					@break
				@endswitch
				</td>

				<td>{{ optional($req->limit_at)->format('Y-m-d') }}</td>

				<td>
					@if($req->archived->where('user_id',auth()->id())->isEmpty())
					<a href="{{ route('requirements.archive_requirement',$req) }}" title="Archivar" class="btn btn-sm btn-outline-primary">
						<i class="fas fa-box"></i>
					</a>
					@else
					<a href="{{ route('requirements.archive_requirement_delete',$req) }}" title="Desarchivar" class="btn btn-sm btn-outline-secondary">
						<i class="fas fa-box-open"></i>
					</a>
					@endif
				</td>
			</tr>
		@endforeach
    </tbody>
</table>

{{ $requirements->links() }}


@endsection

@section('custom_js')

@endsection
