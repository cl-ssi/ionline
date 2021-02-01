@extends('layouts.app')

@section('title', 'Listado de personal a vacunar')

@section('content')

@include('vaccination.partials.nav')

<h3 class="mb-3">Listado de personal a vacunar</h3>

<div class="form-row mb-3">
    <div class="col-12 col-md-12">
        <form method="GET" class="form-horizontal" action="{{ route('vaccination.index') }}">
            <div class="input-group mb-sm-0">
                <input class="form-control" type="text" name="search" autocomplete="off" id="for_search" style="text-transform: uppercase;" placeholder="RUN (sin dígito verificador) / NOMBRE" value="{{$request->search}}" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>Id</th>
            <th>Estab</th>
            <th>Unidad Organ.</th>
            <th>Nombre</th>
            <th>Run</th>
            <th>1° dósis</th>
            <th></th>
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
                <td>
                    <i class="fas fa-eye" {!! ($vaccination->personal_email or $vaccination->inform_method)? 'style="color:#007bff;"' : 'style="color:#cccccc;"' !!}></i>
                </td>
                <td style="width: 110px;"></td>
                <td> <a href="{{ route('vaccination.edit', $vaccination) }}"> <i class="fas fa-edit"></i> </a> </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $vaccinations->appends(request()->query())->links() }}

@endsection

@section('custom_js')

@endsection
