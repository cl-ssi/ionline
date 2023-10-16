@extends('layouts.bt4.app')

@section('content')

@include('suitability.nav')


<div class="card">

    <div class="card-header">
        Agregar firmante o visador
    </div>

    <div class="card-body">
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
                            <option value="signer">Firmante</option>
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
    </div>
</div>

<h3 class="mb-3 mt-5">Firmantes y visadores</h3>

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