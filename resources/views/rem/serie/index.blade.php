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
<h3 class="mb-3">Listado de Series para REM</h3>
<div class="table-responsive-sm">
<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center">SERIES</th>            
        </tr>
    </thead>
    <tbody>
    @forelse($series as $serie)
        <tr>
            <td class="text-center">{{ $serie->name??'' }}</td>            
        </tr>        
        @empty
    @endforelse

    </tbody>
</table>
</div>

@endsection

@section('custom_js')

@endsection