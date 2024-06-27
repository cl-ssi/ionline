@extends('layouts.bt4.app')
@section('title', 'Listado Usuarios Colegio')
@section('content')
@include('suitability.nav')

<div class="container">
    <h1>Usuarios con de Plataforma Idoneidad</h1>

    <form method="GET" action="{{ route('suitability.users.indexUser') }}" class="mb-3">
        <div class="row">
            <div class="col">
                <input type="text" name="search" class="form-control" placeholder="Buscar por Rut, Nombre, Email o Teléfono">
            </div>
            <div class="col">
                <select name="school_id" class="form-control">
                    <option value="">Todos los colegios</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ $request->input('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    @if($users->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Rut</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Colegio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->runFormat }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->psiRequests?->last()->school->name }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                                                <!-- <a href="#" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a> -->
                                <form method="POST" action="{{ route('suitability.users.convertAdmin') }}">
                                    @csrf
                                    <input type="hidden" name="user_external_id" value="{{ $user->id }}">
                                    <input type="hidden" name="school_id" value="{{ $user->psiRequests?->last()->school->id }}">
                                    <button type="submit" class="btn btn-warning btn-sm ml-2">
                                        <i class="fas fa-crown"></i> Nombrar Administrador
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    @else
        <p>No hay usuarios</p>
    @endif




@endsection