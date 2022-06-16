<div>
    
    <div class="input-group mb-3">
        <input type="number" wire:model.debounce.600ms="req_id" class="form-control" placeholder="N°">
        <input type="text" wire:model.debounce.600ms="subject" class="form-control" placeholder="Asunto">
        <select wire:model.debounce.600ms="category" class="form-control">
            <option></option>
            @foreach(auth()->user()->reqCategories->pluck('name') as $category)
            <option>{{ $category }}</option>
            @endforeach
        </select>
        <!--input type="text" wire:model.debounce.600ms="user_involved" class="form-control" placeholder="Usuario involucrado"-->
        <!--input type="text" wire:model.debounce.600ms="parte" class="form-control" placeholder="Origen, N°Origen"-->
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" wire:click="search">
                <i class="fas fa-search" aria-hidden="true"></i></button>
            </div>
    </div>


    @if($requirements->isNotEmpty())
    <h4>Resultado de la busqueda</h4>
    <table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>N°</th>
            <th>Asunto</th>
            <th>Unidad Organizacional</th>
            <th>Funcionario</th>
            <th>Fecha creación</th>
            <th>Transcurridos</th>
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
				<td>{{ $req->events->last()->to_ou->name }}</td>
				<td>{{ $req->events->last()->to_user->fullName }}</td>
				<td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
				<td>{{ $req->created_at->diffForHumans() }}</td>
				<td>@if($req->limit_at <> NULL){{ $req->limit_at->format('Y-m-d')}} @endif</td>

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

    @endif

</div>