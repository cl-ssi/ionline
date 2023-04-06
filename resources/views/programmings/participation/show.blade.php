@extends('layouts.app')

@section('title', 'Participación '.$programming->establishment->type.' '.$programming->establishment->name.' '.$programming->year)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Participación {{ $programming->establishment->type }} {{ $programming->establishment->name }} {{ $programming->year}}
@if($programming->status == 'active')
<a href="{{ route('participation.create', ['programming' => $programming, 'indicatorId' => $activity->id]) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar actividad</a>
@endif
</h3>
<button onclick="tableExcel()" class="btn btn-success mb-1 btn-sm">Exportar Excel</button>
<table id="participation-table" class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th class="text-center align-middle table-dark" rowspan="2">#</th>
            <th class="text-center align-middle table-dark" rowspan="2">Nombre actividad</th>
            <th class="text-center align-middle table-dark" rowspan="2">Total programadas</th>
            <th class="text-center align-middle table-dark" colspan="4">Tareas</th>
            @if($programming->status == 'active')
            <th class="text-center align-middle table-dark" rowspan="2"></th>
            @endif
        </tr>
        <tr class="small">
            <th class="text-center align-middle table-dark">#</th>
            <th class="text-center align-middle table-dark">Nombre</th>
            <th class="text-center align-middle table-dark">Fecha ejecución</th>
            <th class="text-center align-middle table-dark">N° de re programaciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($activity->values as $value)
        <tr class="small">
            <td class="text-left" style="width:20px;" rowspan="{{$value->value}}">{{$loop->iteration}}</td>
            <td class="text-left" rowspan="{{$value->value}}">{{$value->activity_name}}</td>
            <td class="text-center" rowspan="{{$value->value}}">{{$value->value}}</td>
            <td class="text-center">{{$value->tasks->first() ? 1 : ''}}</td>
            <td class="text-left">{{$value->tasks->first()->name ?? '--'}}</td>
            <td class="text-center">{{$value->tasks->first() ? $value->tasks->first()->date->format('d-m-Y') : '--'}}</td>
            <td class="text-center">{{$value->tasks->first() ? $value->tasks->first()->reschedulings()->count() : '--'}}</td>
            @if($programming->status == 'active')
            <td class="text-center align-middle" rowspan="{{$value->value}}">
                <a href="{{ route('participation.edit', ['value' => $value->id, 'programming' => $programming->id]) }}" class="btn btb-flat btn-xs  btn-light btn-sm" >
                <i class="fas fa-edit"></i></a> 
                <form method="POST" action="{{ route('participation.destroy', $value->id) }}" class="d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea eliminar este item?')"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
            @endif
        </tr>
        @for($i = 1 ; $i < $value->value; $i++)
        <tr class="small">
            <td class="text-center">{{isset($value->tasks[$i]) ? $i+1 : ''}}</td>
            <td class="text-left">{{$value->tasks[$i]->name ?? '--'}}</td>
            <td class="text-center">{{isset($value->tasks[$i]) ? $value->tasks[$i]->date->format('d-m-Y') : '--'}}</td>
            <td class="text-center">{{isset($value->tasks[$i]) ? $value->tasks[$i]->reschedulings()->count() : '--'}}</td>
        </tr>
        @endfor

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