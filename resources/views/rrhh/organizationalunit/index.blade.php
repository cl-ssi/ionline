@extends('layouts.app')

@section('title', 'Lista de Unidades Organizacionales')

@section('content')

<h3 class="mb-3">Unidades organizacionales</h3>

<fieldset class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
        	<span class="input-group-text" id="basic-addon"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Ingrese Nombre" name="search" required="">
        <div class="input-group-append">
            <a class="btn btn-primary" href="{{ route('rrhh.organizational-units.create') }}"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
</fieldset>

@foreach($organizationalUnits as $root)

<div class="table-responsive">
	<table class="table table-striped table-sm" id="TableFilter">
		<thead>
			<tr>
				<th scope="col"></th>
				<th scope="col">Nombre</th>
                <th scope="col">Nivel</th>
                <th scope="col">Id Establecimiento</th>
				<th scope="col">Accion</th>
			</tr>
		</thead>
		<tbody>
            <tr>
                <td scope="row">{{ $root->id }}</td>
                <td>&nbsp;&nbsp;-&nbsp;{{ $root->name }}</td>
                <td>{{ $root->level }}</td>
                <td>{{ $root->establishment_id }}</td>
                <td>
                    <a href="{{ route('rrhh.organizational-units.edit', $root->id) }}" class="btn btn-outline-secondary btn-sm">
                    <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
            </tr>

            @foreach($root->childs as $child_level_1)
                <tr>
                    <td scope="row">{{ $child_level_1->id }}</td>
                    <td>&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;{{ $child_level_1->name }}</td>
                    <td>{{ $child_level_1->level }}</td>
                    <td>{{ $child_level_1->establishment_id }}</td>
                    <td>
                        <a href="{{ route('rrhh.organizational-units.edit', $child_level_1->id) }}" class="btn btn-outline-secondary btn-sm">
                        <span class="fas fa-edit" aria-hidden="true"></span></a>
                    </td>
                </tr>
                @foreach($child_level_1->childs as $child_level_2)
                    <tr>
                        <td scope="row">{{ $child_level_2->id }}</td>
                        <td>&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;{{ $child_level_2->name }}</td>
                        <td>{{ $child_level_2->level }}</td>
                        <td>{{ $child_level_2->establishment_id }}</td>
                        <td>
                            <a href="{{ route('rrhh.organizational-units.edit', $child_level_2->id) }}" class="btn btn-outline-secondary btn-sm">
                            <span class="fas fa-edit" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                    @foreach($child_level_2->childs as $child_level_3)
                        <tr>
                            <td scope="row">{{ $child_level_3->id }}</td>
                            <td>&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;
                            {{ $child_level_3->name }}</td>
                            <td>{{ $child_level_3->level }}</td>
                            <td>{{ $child_level_3->establishment_id }}</td>
                            <td>
                                <a href="{{ route('rrhh.organizational-units.edit', $child_level_3->id) }}" class="btn btn-outline-secondary btn-sm">
                                <span class="fas fa-edit" aria-hidden="true"></span></a>
                            </td>
                        </tr>

                        @foreach($child_level_3->childs as $child_level_4)
                            <tr>
                                <td scope="row">{{ $child_level_4->id }}</td>
                                <td>&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;
                                {{ $child_level_4->name }}</td>
                                <td>{{ $child_level_4->level }}</td>
                                <td>{{ $child_level_4->establishment_id }}</td>
                                <td>
                                    <a href="{{ route('rrhh.organizational-units.edit', $child_level_4->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <span class="fas fa-edit" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                            @foreach($child_level_4->childs as $child_level_5)
                                <tr>
                                    <td scope="row">{{ $child_level_5->id }}</td>
                                    <td>&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;
                                    {{ $child_level_5->name }}</td>
                                    <td>{{ $child_level_5->level }}</td>
                                    <td>{{ $child_level_5->establishment_id }}</td>
                                    <td>
                                        <a href="{{ route('rrhh.organizational-units.edit', $child_level_5->id) }}" class="btn btn-outline-secondary btn-sm">
                                        <span class="fas fa-edit" aria-hidden="true"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                    @endforeach

                @endforeach

			@endforeach
		</tbody>
	</table>
</div>
@endforeach

@endsection
