@extends('layouts.app')

@section('title', 'Participación '.$programming->establishment->type.' '.$programming->establishment->name.' '.$programming->year)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Participación {{ $programming->establishment->type }} {{ $programming->establishment->name }} {{ $programming->year}}
@if($programming->status == 'active')
<a href="{{ route('participation.create', ['programming' => $programming, 'indicatorId' => $indicator->id]) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar actividad</a>
@endif
</h3>
<button onclick="tableExcel()" class="btn btn-success mb-1 btn-sm">Exportar Excel</button>
<table id="participation-table" class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th class="text-center align-middle table-dark">#</th>
            <th class="text-center align-middle table-dark">Nombre actividad</th>
            <th class="text-center align-middle table-dark">Total programadas</th>
            @if($programming->status == 'active')
            <th class="text-center align-middle table-dark"></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($indicator->values as $value)
        <tr class="text-right">
            <td class="text-left" style="width:20px;">{{$loop->iteration}}</td>
            <td class="text-left">{{$value->activity_name}}</td>
            <td class="text-center">{{$value->value}}</td>
            @if($programming->status == 'active')
            <td class="text-center align-middle">
                <a href="{{ route('participation.edit', ['value' => $value->id, 'programming' => $programming->id]) }}" class="btn btb-flat btn-xs  btn-light" >
                <i class="fas fa-edit"></i></a> 
                <form method="POST" action="{{ route('participation.destroy', $value->id) }}" class="d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea eliminar este item?')"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
            @endif
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">No hay actividades programadas</td></tr>
        @endforelse
    </tbody>
</table>

@endsection

@section('custom_js')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>  
<script>
    function tableExcel(type, fn, dl) {
        var elt = document.getElementById('participation-table');
        var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
        return dl ?
        XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
        XLSX.writeFile(wb, 'participación-{{ $programming->establishment->type }}-{{ $programming->establishment->name }}-{{ $programming->year}}.xlsx')
    }  
</script>
@endsection