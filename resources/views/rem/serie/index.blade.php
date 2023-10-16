@extends('layouts.bt4.app')

@section('content')
@include('rem.nav')
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
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Series</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($series as $serie)
            <tr>
                <td class="text-center">{{ $serie->name??'' }}</td>
                <td>
                    <form method="POST" class="form-horizontal" action="{{ route('rem.series.destroy', $serie) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea eliminar la serie {{ $serie->name }} ?' )"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            @endforelse

        </tbody>
    </table>
</div>

@endsection

@section('custom_js')

@endsection