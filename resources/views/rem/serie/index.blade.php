@extends('layouts.app')

@section('content')
@canany(['be god','Rem: admin','Rem: user'])
@include('rem.nav')
@endcan
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('rem.series.create') }}">
            Agregar Serie Rem
        </a>
    </div>
</div>


<hr>
<h3 class="mb-3">Listado de Series para el REM</h3>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Serie</th>
            <th>Borrar</th>
        </tr>
    </thead>
    <tbody>
    @forelse($series as $serie)
        <tr>
            <td>{{ $serie->name??'' }}</td>
            <td></td>
        </tr>        
        @empty
    @endforelse

    </tbody>
</table>

@endsection

@section('custom_js')

@endsection