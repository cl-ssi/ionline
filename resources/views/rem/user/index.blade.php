@extends('layouts.bt4.app')

@section('content')
@include('rem.nav')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('rem.users.create') }}">
            Agregar Usuario REM a Establecimiento
        </a>
    </div>
</div>


<hr>
<h3 class="mb-3">Listado de Usuarios con Establecimiento REM</h3>

<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Establecimiento</th>
            <th>Eliminar</th>
        </tr>
    </thead>

    <tbody>
        @foreach($usersRem as $userRem)
        <tr>
            <td>{{ optional($userRem->user)->fullName }}</td>
            <td>{{ $userRem->establishment->name ?? '' }}</td>
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('rem.users.destroy', $userRem->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea eliminar a {{ $userRem->user?->fullName }} como usuario REM del establecimiento {{ $userRem->establishment->name }}? ' )"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>




@endsection

@section('custom_js')

@endsection