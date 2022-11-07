@extends('layouts.app')

@section('content')


<table class="table table-bordered table-sm" id="table_id">
    <thead>
        <tr class="text-center">
            <th>#</th>
            @foreach ($dates as $month)
            <th scope="col">{{ $month->format('Y-m') }}</th>
            @endforeach
        </tr>
        @forelse ($rem_establishments as $rem_establishment)
        <tr>
            <td class="text-center font-weight-bold">
                {{ $rem_establishment->establishment->name }}
            </td>
            @foreach ($dates as $month)
            <td scope="col">
                @livewire('rem.upload-rem',
                [
                'year' => $month->format('Y'),
                'month' => $month->format('m'),
                'establishment' => $rem_establishment->establishment,
                ]
                )
            </td>
            @endforeach
        </tr>
        @empty
        <tr>
            <td colspan="12">
                No Tiene Asignado Establecimientos para subir REM, contactarse con su encargado de estadistica para que le asigne alguno en caso de ser necesario
            </td>
        </tr>
        @endforelse
    </thead>
</table>




@endsection

@section('custom_js')

@endsection