@extends('layouts.app')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Firmantes y visadores</h3>

<form method="post" action="{{route('suitability.configSignatureAdd')}}">
    @csrf
    @method('POST')
    <div style="margin-bottom: 10px;" class="row">

        <fieldset class="form-group col-lg-9">
            <label for="">Buscar usuario</label>
            @livewire('search-select-user') 
        </fieldset>


        <fieldset class="form-group col-lg-3">
            <label for="for_sign_order">Tipo</label>
                <select name="type" id="for_type" class="form-control" required>
                    <option value=""></option>
                    <option value="signer">Firmador</option>
                    <option value="visator">Visador</option>
                </select>
        </fieldset>

        <div class='col'>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-plus"></i> Agregar 
            </button> 
        </div>

    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>            
            <th>Tipo</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
    @foreach($signers as $signer)
        <tr>
            <td>{{ $signer->user->fullName ?? '' }}</td>      
            <td>
                {{$signer->typeEsp}}
            </td>
            <td>
                <a href="{{route('suitability.configSignatureDelete', $signer->id)}}" onclick="return confirm('Desea eliminar el firmante?')" class="btn btn-sm btn-outline-secondary" title="Borrar">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection