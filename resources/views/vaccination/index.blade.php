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
</div

<div class="table-responsive">
<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>Id</th>
            <th>Estab</th>
            <th class="d-none d-md-table-cell">Unidad Organ.</th>
            <th></th>
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
                <td>{{ $vaccination->aliasEstab }}</td>
                <td class="d-none d-md-table-cell" style="width: 100px;">{{ $vaccination->organizationalUnit }}</td>
                <td>
                    @switch($vaccination->inform_method)
                        @case(1)
                            <i class="fas fa-eye" style="color:#007bff;"></i>
                            @break

                        @case(2)
                            <i class="fas fa-phone" style="color:#007bff;"></i>
                            @break
                        @case(3)
                            <i class="fas fa-envelope" style="color:#007bff;"></i>
                            @break
                        @default
                            <i class="fas fa-eye" style="color:#cccccc;"></i>
                    @endswitch
                </td>
                <td nowrap>{{ $vaccination->fullName() }}</td>
                <td nowrap class="text-right" {!! Helper::validaRut($vaccination->runFormat) ? '' : 'style="color:red;"' !!}>
                    {{ $vaccination->runFormat }}
                </td>
                <td nowrap>
                    {{ $vaccination->first_dose->format('d-m-Y') ?? '' }} {{ $vaccination->first_dose->format('H:i') ?? '' }}
                </td>
                <td nowrap></td>
                <td> <a href="{{ route('vaccination.edit', $vaccination) }}"> <i class="fas fa-edit"></i> </a> </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
{{ $vaccinations->appends(request()->query())->links() }}

@endsection

@section('custom_js')

@endsection
