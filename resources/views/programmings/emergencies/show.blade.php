@extends('layouts.app')

@section('title', 'Emergencias y desastres '.$programming->establishment->type.' '.$programming->establishment->name.' '.$programming->year)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Emergencias y desastres {{ $programming->establishment->type }} {{ $programming->establishment->name }} {{ $programming->year}} 
<a href="{{ route('emergencies.create', $programming) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar item</a>
</h3>
<button onclick="tableExcel()" class="btn btn-success mb-1 btn-sm">Exportar Excel</button>
<table id="emergencies-table" class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th class="text-center align-middle table-dark">Peligro / Amenaza</th>
            <th class="text-center align-middle table-dark">Frecuencia ocurrencia (a)</th>
            <th class="text-center align-middle table-dark">Nivel de impacto (b)</th>
            <th class="text-center align-middle table-dark">Rol del Servicio Salud (c)</th>
            <th class="text-center align-middle table-dark">Factor (a*b*c)</th>
            <th class="text-center align-middle table-dark">Descripción de los posibles efectos</th>
            <th class="text-center align-middle table-dark">Medidas de prevención y mitigación gestionadas para los posibles efectos</th>
            <th class="text-center align-middle table-dark"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($emergencies as $emergency)
        <tr class="small">
            <td class="text-left">{{ $emergency->name != 'OTRO' ? $emergency->name : $emergency->another_name}} ({{$emergency->origin}})</td>
            <td class="text-center">{{$emergency->frecuency}}</td>
            <td class="text-center">{{$emergency->impact_level}}</td>
            <td class="text-center">{{$emergency->ss_rol}}</td>
            <td class="text-center">{{$emergency->factor }}</td>
            @php($items = explode("\r", $emergency->description))
            <td class="text-left"><ul>@foreach($items as $item) <li>{{$item}}</li> @endforeach</ul></td>
            @php($items = explode("\r", $emergency->measures))
            <td class="text-left"><ul>@foreach($items as $item) <li>{{$item}}</li> @endforeach</ul></td>
            <td class="text-center align-middle">
                <a href="{{ route('emergencies.edit', $emergency->id) }}" class="btn btb-flat btn-xs  btn-light" >
                <i class="fas fa-edit"></i></a> 
                <form method="POST" action="{{ route('emergencies.destroy', $emergency->id) }}" class="d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea eliminar este item?')"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center small">No hay registro de emergencias y desastres</td></tr>
        @endforelse
    </tbody>
</table>

@endsection

@section('custom_js')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>  
<script>
    function tableExcel(type, fn, dl) {
        var elt = document.getElementById('emergencies-table');
        var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
        return dl ?
        XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
        XLSX.writeFile(wb, 'emergencias-y-desastres-{{ $programming->establishment->type }}-{{ $programming->establishment->name }}-{{ $programming->year}}.xlsx')
    }  
</script>
@endsection