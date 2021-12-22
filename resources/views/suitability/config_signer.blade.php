@extends('layouts.app')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Firmantes</h3>

<form method="post" action="{{route('suitability.configSignatureAdd')}}">
    @csrf
    @method('POST')
    <div style="margin-bottom: 10px;" class="row">

            <div class="col-lg-6">
                @livewire('search-select-user') 
            </div>

            <div class="col-lg-3">
                <select name="sign_order" id="for_sign_order" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>
            </div>

            <div class="col-lg-3">
                <button type="submit" class="btn btn-success" >
                    <i class="fas fa-plus"></i> Agregar Firmador
                </button> 
            </div>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>            
            <th>Orden</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
    @foreach($signers as $signer)
        <tr>
            <td>{{ $signer->user->name ?? '' }}</td>      
            <td>
                {{$signer->sign_order}}
            </td>
            <td>
                <a href="{{route('suitability.configSignatureDelete', $signer->id)}}"  class="btn btn-sm btn-outline-secondary" title="Borrar">
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