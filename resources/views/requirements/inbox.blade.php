@extends('layouts.app')

@section('title', 'Requerimientos')

@section('content')

@include('requirements.partials.nav')

<h3 class="mb-3">Recepcionados Abiertos</h3>

<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>Cat.</th>
            <th>N°</th>
            <th>Remitente</th>
            <th>Funcionario</th>
            <th>Asunto</th>
            <th>Fecha creación</th>
            <th>Días transcurridos</th>
            <th>Fecha límite</th>
            <!-- <th>Fecha cierre</th> -->
            <th>Última actividad</th>
            <td></td>
        </tr>
    </thead>
    <tbody>
      @foreach($openRequirements as $open)
  			<tr>
          <td>
            @foreach($open->categories as $category)
              @if(Auth::user()->id == $category->user_id)
                <span class='badge badge-primary' style='background-color: #{{$category->color}};'>{{$category->name}}</span><br>
              @endif
            @endforeach
          </td>
					<td>{{$open->id}}</td>
					<td>{{$open->subject}}</td>
					<td>{{$open->events->first()->user->organizationalUnit->name}}</td>
					<td>{{$open->events->first()->user->getFullNameAttribute()}}</td>
					<td>{{Carbon\Carbon::parse($open->created_at)->format('d/m/Y H:i')}}</td>
					<td>{{Carbon\Carbon::parse($open->created_at)->diffInDays(Carbon\Carbon::now())}}</td>
					<td>@if($open->limit_at <> NULL){{Carbon\Carbon::parse($open->limit_at)->format('d/m/Y')}} @endif</td>
          <td>{{Carbon\Carbon::parse($open->updated_at)->format('d/m/Y')}}</td>
					<td>
						<a href="{{ route('requirements.show',$open->id) }}">
								<i class="fas fa-edit"></i>
						</a>
					</td>
  			</tr>
  		@endforeach
    </tbody>
</table>


<h3 class="mb-3">Recepcionados Cerrados</h3>

<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>Cat.</th>
            <th>N°</th>
            <th>Remitente</th>
            <th>Funcionario</th>
            <th>Asunto</th>
            <th>Fecha creación</th>
            <th>Días transcurridos</th>
            <th>Fecha límite</th>
            <th>Fecha cierre</th>
            <!-- <th>Última actividad</th> -->
            <th></th>
        </tr>
    </thead>
    <tbody>
      @foreach($closedRequirements as $closed)
  			<tr>
            <td>
              @foreach($closed->categories as $category)
                @if(Auth::user()->id == $category->user_id)
                  <span class='badge badge-primary' style='background-color: #{{$category->color}};'>{{$category->name}}</span><br>
                @endif
              @endforeach
            </td>
  					<td>{{$closed->id}}</td>
  					<td>{{$closed->subject}}</td>
            <td>{{$closed->events->first()->user->organizationalUnit->name}}</td>
  					<td>{{$closed->events->first()->user->getFullNameAttribute()}}</td>
  					<td>{{Carbon\Carbon::parse($closed->created_at)->format('d/m/Y H:i')}}</td>
  					<td>{{Carbon\Carbon::parse($closed->created_at)->diffInDays(Carbon\Carbon::now())}}</td>
  					<td>@if($closed->limit_at <> NULL){{Carbon\Carbon::parse($closed->limit_at)->format('d/m/Y')}} @endif</td>
            <td>{{Carbon\Carbon::parse($closed->updated_at)->format('d/m/Y')}}</td>
  					<td>
  						<a href="{{ route('requirements.show',$closed->id) }}">
  								<i class="fas fa-edit"></i>
  						</a>
  					</td>
  			</tr>
  		@endforeach
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
