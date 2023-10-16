@extends('layouts.bt4.app')

@section('content')

<h3 class="mb-3">Carga de REMs</h3>

@canany(['be god','Rem: admin'])
<a class="btn btn-primary" href="{{ route('rem.users.index') }}">
    <i class="fas fa-users fa-fw"></i> Usuarios REM
</a>
<br>
<br>
@endcan

<table class="table table-bordered table-sm small">
    <thead>
        <tr class="text-center">
            <th>Período</th>
            @foreach(array_reverse($periods) as $period)
            <th>{{ $period->format('Y-m') }}</th>
            @endforeach
        </tr>

        @forelse($establishments as $remFiles)
        <tr>
            <td class="text-center font-weight-bold">
                {{ $remFiles[0]->establishment->name }}
            </td>
            @foreach($remFiles as $remFile)
            <td>
                @livewire('rem.upload-rem', [$remFile])
            </td>
            @endforeach
        </tr>
        @empty
        <tr>
            <td colspan="8">
                No tiene asignado establecimientos para cargar REMs, por favor contácte a su encargado de estadistica para que le asigne alguno en caso de ser necesario.
            </td>
        </tr>
        @endforelse
    </thead>
</table>

@endsection

@section('custom_js')

@endsection