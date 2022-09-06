<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>N°</th>
            <th>Asunto</th>
            <th width="160">Creado</th>
            <th width="160">Ultimo evento</th>
            <th width="100">Fecha límite</th>
            <td></td>
        </tr>
    </thead>
    <tbody>
		@foreach($requirements as $req)

			@switch($req->status)
				@case('creado')
					@if($req->user_id == auth()->id())
						<tr class="alert-info">
					@else
						<tr class="alert-light">
					@endif
					@break
				@case('respondido') 
					<tr class="alert-warning"> @break
				@case('cerrado') 
					<tr class="alert-success"> @break
				@case('derivado') 
					<tr class="alert-primary"> @break
				@case('reabierto') 
					<tr class="alert-light"> @break
			@endswitch
			
			@php
			$copia = ($req->events->where('to_user_id',$user->id)->count() == $req->ccEvents->where('to_user_id',$user->id)->count())?'alert-secondary':'';
			@endphp

				<td class="{{ $copia }}">
					{{ $req->id }}
					<br>
					<a href="{{ route('requirements.show',$req->id) }}" class="btn btn-sm btn-outline-primary">
						<i class="fas fa-edit"></i>
					</a>
				</td>

				<td class="{{ $copia }}">
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

				<td class="{{ $copia }}">
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
                <br>

                @if($req->unreadedEvents)
                <i class="fas fa-eye text-success"></i>
                {{ $req->unreadedEvents  }}
				</td>
                @endif

				<td class="{{ $copia }}">
					@if($req->limit_at)
					
						<div class="text-danger">
							<i class="fas fa-fw fa-chess-king"></i>
							{{ $req->limit_at->format('Y-m-d') }}
						</div>

						@if($req->events->whereNotNull('limit_at')->where('status','!=','en copia')->count() >= 1)
							@foreach($req->events->whereNotNull('limit_at')->where('status','!=','en copia') as $event)

								<div class="{{ now() >= $event->limit_at ? 'text-danger':'' }}">
									<i class="fas fa-fw fa-chess-pawn"></i>
									{{ $event->limit_at->format('Y-m-d') }}
								</div>

							@endforeach
						@endif

					@endif

				</td>

				<td class="{{ $copia }}">
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
