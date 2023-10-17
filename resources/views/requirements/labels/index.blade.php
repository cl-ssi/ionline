@extends('layouts.bt4.app')

@section('title', 'Requerimientos')

@section('content')

@include('requirements.partials.nav')

<div class="row">
    <div class="col">
        <h3 class="mb-3">Listado de etiquetas</h3>
    </div>
    <div class="col text-right">
        <a class="btn btn-primary" href="{{route('requirements.labels.create')}}">
            <i class="fas fa-tags"></i> Nueva etiqueta
        </a>
    </div>
</div>

<ul>
    <li>Las etiquetas son personales</li>
    <li>Usted puede filtrar los requerimientos de su bandeja a través de una etiqueta</li>
    <li>Un requerimiento puede tener varias etiquetas</li>
</ul>


<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <!-- <th>id</th> -->
            <th>Nombre</th>
            <th>Color</th>
            <td width="60"></td>
        </tr>
    </thead>
    <tbody>
        @foreach($labels as $key => $label)
            <tr>
                <td>{{ $label->name }}</td>
                <td>
                    <span class="btn btn-secondary" style="background-color: #{{ $label->color }};">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                </td>
                <td>
                    <a class="btn btn-outline-primary" href="{{ route('requirements.labels.edit', $label) }}">
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
