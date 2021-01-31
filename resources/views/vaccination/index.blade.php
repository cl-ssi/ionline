@extends('layouts.app')

@section('title', 'Listado de personal a vacunar')

@section('content')
<h3 class="mb-3">Listado de personal a vacunar</h3>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Estab</th>
            <th>Unidad Organ.</th>
            <th>Nombre</th>
            <th>Run</th>
            <th>Primera dósis</th>
            <th>Segunda dósis</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vaccinations as $key => $vaccination)
            <tr>
                <td>{{ $vaccination->id }}</td>
                <td>{{ $vaccination->establishment->name }}</td>
                <td>{{ $vaccination->organizationalUnit }}</td>
                <td>{{ $vaccination->fullName() }}</td>
                <td>{{ $vaccination->run }} - {{ $vaccination->dv }}</td>
                <td>{{ $vaccination->first_dose->format('H:i') ?? '' }}</td>
                <td>{{ $vaccination->first_dose->format('Y-m-d') ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
