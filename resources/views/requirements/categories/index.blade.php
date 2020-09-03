@extends('layouts.app')

@section('title', 'Requerimientos')

@section('content')

@include('requirements.partials.nav')

<h3 class="mb-3">Listado de categorías</h3>

<div class="mb-3">
	<a class="btn btn-primary" href="{{route('requirements.categories.create')}}">
		<i class="fas fa-shopping-cart"></i> Nueva categoría
	</a>
</div>

<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <!-- <th>id</th> -->
            <th>Nombre</th>
            <th>Color</th>
            <td></td>
        </tr>
    </thead>
    <tbody>
			@foreach($categories as $key => $category)
				<tr>
						<!-- <td>1{{$category->id}}</td> -->
						<td>{{$category->name}}</td>
						<td><span class="badge badge-primary" style="background-color: #{{$category->color}};">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
						<td>
							<a href="{{ route('requirements.categories.edit', $category) }}">
									<i class="fas fa-edit"></i>
							</a>
						</td>
						</td>
				</tr>
			@endforeach
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
