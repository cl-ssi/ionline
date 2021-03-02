@extends('layouts.app')

@section('title', 'Listado de personal a vacunar')

@section('content')

@include('vaccination.partials.nav')

<h3 class="mb-3">Listado de personal a vacunar</h3>


<form method="GET" class="form-horizontal" action="{{ route('vaccination.slots') }}">
    <div class="input-group mb-sm-4">
        <input class="form-control" type="text" name="search" autocomplete="off" 
            id="for_search" style="text-transform: uppercase;" 
            placeholder="RUN (sin dígito verificador) / NOMBRE" 
            value="{{ $request->search ?? '' }}" required>
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </div>
    </div>
</form>
@if ($records)
<h4>Resultados de Busqueda</h4>
<div class="table-responsive">
<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th></th>
            <th>Estab</th>
            <th class="d-none d-md-table-cell">Unidad Organ.</th>
            <th></th>
            <th>Nombre</th>
            <th>Run</th>
            <th>Cita 1° dósis</th>
            <th>Inoc. 1°</th>
            <th>Cita 2° dósis</th>
            <th>Inoc. 2°</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($records as $key => $vaccination)
            <tr>
                <td>{{ ++$key }}</td>
                <td class="small">
                    <form method="POST" class="form-horizontal" action="{{ route('vaccination.arrival', $vaccination) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm"><i class="fas fa-running"></i></button>
                    </form>
                </td>
                <td>
                    @if($vaccination->first_dose_at)
                        <div class="btn btn-sm" style="color:#007bff;"><i class="fas fa-syringe"></i></div>
                    @else
                    <form method="POST" class="form-horizontal" action="{{ route('vaccination.vaccinate',$vaccination) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm" onclick="return clicked('{{$vaccination->fullName()}}');"><i class="fas fa-syringe"></i></button>
                    </form>
                    @endif
                </td>
                <td>{{ $vaccination->aliasEstab }}</td>
                <td class="d-none d-md-table-cell" style="width: 200px;">{{ $vaccination->organizationalUnit }}</td>
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
                    {{ optional($vaccination->first_dose)->format('d-m-Y H:i') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->first_dose_at)->format('d-m-Y') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->second_dose)->format('d-m-Y H:i') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->second_dose_at)->format('d-m-Y') }}
                </td>
                <td> <a href="{{ route('vaccination.edit', $vaccination) }}"> <i class="fas fa-edit"></i> </a> </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>


@endif




<h4>En sala de espera</h4>

<div class="table-responsive">
<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>Estab</th>
            <th class="d-none d-md-table-cell">Unidad Organ.</th>
            <th></th>
            <th>Nombre</th>
            <th>Run</th>
            <th>Cita 1° dósis</th>
            <th>Inoc. 1°</th>
            <th>Cita 2° dósis</th>
            <th>Inoc. 2°</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($arrivals as $key => $vaccination)
            <tr>
                <td>{{ ++$key }}</td>
                <td class="small">
                    <form method="POST" class="form-horizontal" action="{{ route('vaccination.arrival', [$vaccination,'true']) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm"><i class="fas fa-running"></i></button>
                    </form>
                </td>
                <td>
                    <form method="POST" class="form-horizontal" action="{{ route('vaccination.dome',$vaccination) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm"><i class="fas fa-igloo"></i></button>
                    </form>
                </td>
                <td>{{ $vaccination->aliasEstab }}</td>
                <td class="d-none d-md-table-cell" style="width: 200px;">{{ $vaccination->organizationalUnit }}</td>
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
                    {{ optional($vaccination->first_dose)->format('d-m-Y H:i') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->first_dose_at)->format('d-m-Y') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->second_dose)->format('d-m-Y H:i') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->second_dose_at)->format('d-m-Y') }}
                </td>
                <td> <a href="{{ route('vaccination.edit', $vaccination) }}"> <i class="fas fa-edit"></i> </a> </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>




@foreach($slots as $slot)
<h4>{{ $slot->start_at->format('H:i') }}</h4>

<div class="table-responsive">
<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Estab</th>
            <th class="d-none d-md-table-cell">Unidad Organ.</th>
            <th></th>
            <th>Nombre</th>
            <th>Run</th>
            <th>Cita 1° dósis</th>
            <th>Inoc. 1°</th>
            <th>Cita 2° dósis</th>
            <th>Inoc. 2°</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($slot->bookings as $key => $vaccination)
            <tr class="{{ ($vaccination->arrival_at)? 'table-success':''}}">
                <td>{{ ++$key }}</td>
                <td class="small">
                    <form method="POST" class="form-horizontal" action="{{ route('vaccination.arrival', $vaccination) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm"><i class="fas fa-running"></i></button>
                    </form>
                </td>
                <td>{{ $vaccination->aliasEstab }}</td>
                <td class="d-none d-md-table-cell" style="width: 200px;">{{ $vaccination->organizationalUnit }}</td>
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
                    {{ optional($vaccination->first_dose)->format('d-m-Y H:i') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->first_dose_at)->format('d-m-Y') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->second_dose)->format('d-m-Y H:i') }}
                </td>
                <td nowrap>
                    {{ optional($vaccination->second_dose_at)->format('d-m-Y') }}
                </td>
                <td> <a href="{{ route('vaccination.edit', $vaccination) }}"> <i class="fas fa-edit"></i> </a> </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
@endforeach

@endsection

@section('custom_js')
<script type="text/javascript">
    function clicked(user) {
        return confirm('Desea registrar que se ha vacunado '+user+'?');
    }
</script>
@endsection
