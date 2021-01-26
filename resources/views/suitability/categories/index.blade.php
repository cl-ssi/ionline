@extends('layouts.app')

@section('content')

@include('suitability.nav')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('suitability.categories.create') }}">
            Agregar Examen
        </a>
    </div>
</div>

<h3 class="mb-3">Listado de Tipos de Examenes</h3>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>            
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->name ?? '' }}</td>      
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection