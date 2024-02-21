@extends('layouts.bt5.app')

@section('title', 'Crear nuevo Rol')

@section('content')

<h3 class="mb-3">Crear nuevo Rol</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.roles.store') }}">
    @csrf
    @method('POST')

    <div class="row g-2">

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name"
                placeholder="Nombre del rol" name="name" required>
        </fieldset>

        <fieldset class="form-group col-md-8">
            <label for="for_description">Descripción</label>
            <input type="text" class="form-control" id="for_description"
                placeholder="Descripciól del rol" name="description">
        </fieldset>
    </div>

    @php $anterior = null; @endphp

    @foreach($permissions as $permission)
        @if( current(explode(':', $permission->name)) != current(explode(':', $anterior)))
            <hr>
        @endif
        @php $anterior = $permission->name; @endphp
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="{{$permission->name}}"
                name="permissions[]" value="{{ $permission->name }}">
            <label class="form-check-label" for="{{$permission->name}}">
                {{ $permission->name }}
                <small class="text-secondary">{{ $permission->description }}</small>
            </label>
        </div>
    @endforeach

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>

        <a class="btn btn-outline-secondary" href="{{ route('parameters.roles.index') }}">Volver</a>
    </div>
</form>

@endsection

@section('custom_js')

@endsection
