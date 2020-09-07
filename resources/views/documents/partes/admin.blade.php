@extends('layouts.app')

@section('title', 'Documentos Administración')

@section('content')

@include('documents.partes.partials.nav')

<h3>Panel de administración módulo documentos</h3>

<div class="row mb-3">
    <div class="col-9">

        <fieldset class="form-group">
            <select multiple class="custom-select" id="inputGroupSelect04" size="10">
                @foreach($ous as $ou)
                    <option value="{{$ou->id}}">{{$ou->name}}</option>
                @endforeach
            </select>
        </fieldset>

    </div>

    <div class="col-3">

        <fieldset class="form-group">
            <label for="">Función</label>
            <select multiple class="custom-select" id="inputGroupSelect04" size="3">
                <option>Encargado</option>
                <option>Subrogante</option>
                <option>Secretario</option>
            </select>
        </fieldset>


        <fieldset class="form-group">
            <label for="">Id de usuario (sin digito)</label>
            <input type="text" class="form-control" name="user_id">
        </fieldset>

        <button class="form-control btn btn-primary">Asignar</button>

    </div>
</div>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Unidad</th>
            <th>Funcion</th>
            <th>Usuario</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Tic</td>
            <td>Secretario</td>
            <td>Alvaro Torres</td>
            <td style="width: 100px;"><button class="form-control btn btn-sm btn-danger"><i class="fas fa-trash"></i> Eliminar </button></td>
        </tr>
        <tr>
            <td>Planificacion</td>
            <td>Encargado</td>
            <td>José Donoso</td>
            <td style="width: 100px;"><button class="form-control btn btn-sm btn-danger"><i class="fas fa-trash"></i> Eliminar </button></td>
        </tr>

    </tbody>
</table>


@endsection
