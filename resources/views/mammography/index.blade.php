@extends('layouts.bt4.app')

@section('title', 'Listado de personal a vacunar')

@section('content')

@include('mammography.partials.nav')

<h3 class="mb-3">Listado de personal con fecha de exámen</h3>

<form method="GET" class="form-horizontal" action="{{ route('mammography.index') }}">
    <div class="input-group mb-sm-4">
        <input class="form-control" type="text" name="search" autocomplete="off" id="for_search" style="text-transform: uppercase;" placeholder="RUN (sin dígito verificador) / NOMBRE" value="{{$request->search}}" required>
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </div>
    </div>
</form>


<div class="table-responsive">
<table class="table table-sm table-bordered small">
    <thead>
        <tr>
            <th>Id</th>
            <th>Run</th>
            <th>Nombre</th>
            <th>Fecha de Reserva</th>
            <th>Teléfono</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mammograms as $key => $vaccination)
            <tr>
                <td class="small">{{ $vaccination->id }}</td>
                <td nowrap class="text-right" {!! Helper::validaRut($vaccination->runFormat) ? '' : 'style="color:red;"' !!}>
                    {{ $vaccination->runFormat }}
                </td>
                <td nowrap>{{ $vaccination->fullName() }}</td>
                <td nowrap>
                    {{ optional($vaccination->exam_date)->format('d-m-Y H:i') }}
                </td>
                <td nowrap>{{ $vaccination->telephone }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $mammograms->appends(request()->query())->links() }}
</div>


@endsection

@section('custom_js')
<script type="text/javascript">
    function clicked(user, dose) {
        return confirm('Desea registrar que se ha vacunado '+user+' para la '+dose+' dosis?');
    }
</script>
@endsection
