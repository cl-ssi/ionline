@extends('layouts.app')

@section('content')

@include('suitability.nav')
<div style="margin-bottom: 10px;" class="row">
    
            @livewire('search-select-user') 

    <div class="col-lg-3">
        <a class="btn btn-success" href="{{ route('suitability.categories.create') }}">
            <i class="fas fa-plus"></i> Agregar Firmador
        </a> 
    </div>
</div>

<h3 class="mb-3">Firmante</h3>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>            
            <th>Orden</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
    {{-- @foreach($categories as $category)
        <tr>
            <td>{{ $category->name ?? '' }}</td>      
            <td>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
    @endforeach --}}
    </tbody>

</table>


@endsection

@section('custom_js')

@endsection