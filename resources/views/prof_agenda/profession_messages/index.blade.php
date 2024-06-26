@extends('layouts.bt4.app')

@section('title', 'Lista de mensajes por especialidad')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="inline">Mensajes por especialidad
	<a href="{{ route('prof_agenda.profession_messages.create') }}" class="btn btn-primary">Crear</a>
</h3>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>Id</th>
			<th nowrap>Profesión</th>
            <th nowrap>Glosa/Texto</th>
            <th style="width:10%"></th>
            <th style="width:10%"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($professionMessages as $professionMessage)
		<tr>
            <td>{{ $professionMessage->id}}</td>
			<td nowrap>{{ $professionMessage->profession->name }}</td>
            <td>{{$professionMessage->text}}</td>
            <td style="width:10%">
				<a href="{{ route('prof_agenda.profession_messages.edit', $professionMessage) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
            <td style="width:10%">
                <form method="POST" class="form-horizontal" action="{{ route('prof_agenda.profession_messages.destroy', $professionMessage) }}">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('¿Está seguro que desea eliminar este mensaje de la profesión?')">
                            <i class="fas fa-trash"></i>
                        </button>
                </form>
                </td>
            </td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection

@section('custom_js')

@endsection
