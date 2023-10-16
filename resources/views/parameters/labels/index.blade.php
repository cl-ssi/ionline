@extends('layouts.bt4.app')

@section('title', 'Etiquetas')

@section('content')

<div class="row">
    <div class="col">
        <h3 class="mb-3">Etiquetas de {{ $module }}</h3>
    </div>
    <div class="col text-right">
        <a
            class="btn btn-primary mb-3"
            href="{{ route('parameters.labels.create', $module) }}"
        >
            Crear
        </a>
    </div>
</div>

<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Color</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($labels as $label)
        <tr>
            <td>{{ $label->name ?? '' }}</td>
            <td>
                <span
                    class="badge badge-primary"
                    style="background-color: #{{ $label->color }};"
                >
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </span>
            </td>
            <td>
                <a href="{{ route('parameters.labels.edit', $label) }}">
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
