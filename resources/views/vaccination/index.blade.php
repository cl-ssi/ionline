@extends('layouts.app')

@section('title', 'Listado de personal a vacunar')

@section('content')
<h3 class="mb-3">Listado de personal a vacunar</h3>

<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>Id</th>
            <th>Estab</th>
            <th>Unidad Organ.</th>
            <th>Nombre</th>
            <th>Run</th>
            <th>1° dósis</th>
            <th>2° dósis</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vaccinations as $key => $vaccination)
            <tr>
                <td class="small">{{ $vaccination->id }}</td>
                <td>{{ $vaccination->establishment->name }}</td>
                <td style="width: 100px;">{{ $vaccination->organizationalUnit }}</td>
                <td nowrap>{{ $vaccination->fullName() }}</td>
                <td nowrap class="text-right">{{ $vaccination->run }}-{{ $vaccination->dv }}</td>
                <td style="width: 110px;">
                    {{ $vaccination->first_dose->format('d-m-Y') ?? '' }} {{ $vaccination->first_dose->format('H:i') ?? '' }}
                </td>
                <td style="width: 110px;"></td>
                <td> <a href="{{ route('vaccination.edit', $vaccination) }}"> <i class="fas fa-edit"></i> </a> </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
