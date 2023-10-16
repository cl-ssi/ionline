@extends('layouts.bt4.app')

@section('title', 'Lista de Programas')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Programas 
<form class="form-inline float-right mb-3" method="GET" action="{{ route('agreements.programs.index') }}">
  <div class="input-group">
    <input type="text" class="form-control" name="program_name" id="program_name" value="{{ request()->program_name }}" placeholder="Buscar por programa" aria-label="Buscar por programa" aria-describedby="button-addon2">
    @if(request()->has('program_name') && strlen(request()->program_name) > 0)
    <span class="input-group-append">
        <button id="clear" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;" type="button">
            <i class="fa fa-times"></i>
        </button>
    </span>
    @endif
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">
            <i class="fas fa-search" aria-hidden="true"></i>
        </button>
    </div>
	</div>
</form>
</h3>

<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th>Id</th>
            <th>Nombre</th>
            <th>Componentes</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programs as $program)
        <tr class="small">
            <td>{{ $program->id }}</td>
            <td>{{ $program->name }}</td>
            <td>
                <ul>
                    @foreach($program->components as $component)
                        <li>{{ $component->name }}</li>
                    @endforeach
                </ul>
            </td>
            <td><a href="{{ route('agreements.programs.show', $program->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit" aria-hidden="true"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')
<script type="text/javascript">
    $("#clear").on("click" , function() {
        $("input[type=text]").val("");
        $("span.input-group-append").hide();
    });
</script>
@endsection