@extends('layouts.app')

@section('title', 'Lista de Wingles')

@section('content')

<h3 class="mb-3">Banda Ancha Móvil</h3>

<fieldset class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <a class="btn btn-primary" href="{{ route('resources.wingle.create') }}">
                <i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>

        <input type="text" class="form-control" id="forsearch" onkeyup="filter(4)"
            placeholder="Filtro: IMEI" name="search" required>

        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search" aria-hidden="true"></i></button>
        </div>
    </div>
</fieldset>

<div class="table-responsive">

    <table class="table table-striped table-sm" id="TableFilter">
        <thead>
            <tr>
                <th></th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Compañia</th>
                <th>IMEI</th>
                <th>Password Activación</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($wingles as $key => $wingle)
                <tr>
                    <td>{{ ++$key }} </td>
                    <td>{{ $wingle->brand }}</td>
                    <td>{{ $wingle->model}}</td>
                    <td>{{ $wingle->company}}</td>
                    <td>{{ $wingle->imei}}</td>
                    <td>{{ $wingle->password}}</td>
                    <td>
                        <a href="{{ route('resources.wingle.edit', $wingle->id) }}"
                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i> </a>

			        </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
