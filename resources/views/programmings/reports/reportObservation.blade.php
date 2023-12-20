@extends('layouts.bt4.app')

@section('title', 'Lista de Items')

@section('content')

@include('programmings/nav')


<button onclick="tableExcel('xlsx')" class="btn btn-success float-right btn-sm">Exportar Excel</button>

<h4 class="mb-3"><a href="{{ url()->previous() }}" class="btn btb-flat btn-sm btn-dark" >
                    <i class="fas fa-arrow-left small"></i> 
                    <span class="small">Volver</span> 
    </a> Informe de Observaciones en Programación Númerica</h4>

<h6><i>Total observaciones: {{$pendingItems->count() + $reviewItems->count()}}</i></h6>
<table id="tblData" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover  ">
    <thead>
        <tr style="font-size:75%;">
            <th class="text-center align-middle" colspan="7">INFORME DE OBSERVACIONES </th>
        </tr>
        <tr class="small " style="font-size:60%;">
            <th class="text-center align-middle">#</th>
            <th class="text-center align-middle">Nº REV.</th>
            <th class="text-center align-middle">TRAZADORA</th>
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">CICLO</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
            <th class="text-center align-middle table-dark">EVALUACIÓN</th>
            <th class="text-center align-middle table-dark">¿SE ACEPTA?</th>
            <th class="text-center align-middle table-dark">OBSERVACIÓN</th>
            <th class="text-center align-middle table-dark">EVALUADO POR</th>
            @if($programming->status == 'active')<th class="text-center align-middle table-dark">REVISAR</th>@endif
            @can('Reviews: delete')
            <th class="text-center align-middle table-dark">ELIMINAR</th>
            @endcan
        </tr>
    </thead>
    <tbody style="font-size:70%;">
    @php($key = 1)
    @foreach($pendingItems as $pendingItem)
        <tr class="small">
            <td class="text-center align-middle">{{$key}}</td>
            <td class="text-center align-middle"></td>
            <td class="text-center align-middle">{{ $pendingItem->activityItem->int_code ?? '' }}</td>
            <td class="text-center align-middle">{{ $pendingItem->activityItem->activity_name ?? '' }}</td>
            <td class="text-center align-middle">{{ $pendingItem->activityItem->vital_cycle ?? '' }}</td>
            <td class="text-center align-middle">{{ $pendingItem->activityItem->action_type ?? '' }}</td>
            <td class="text-center align-middle">{{ $pendingItem->activityItem->def_target_population ?? '' }}</td>
            <td class="text-center align-middle">No se ha programado aún para su evaluación</td>
            <td class="text-center align-middle"></td>
            <td class="text-center align-middle">{{ $pendingItem->observation }}</td>
            <td class="text-center align-middle">{{ $pendingItem->requestedBy->fullName ?? '' }}</td>
            <td class="text-center align-middle">@if($programming->status == 'active')<a href="{{ route('programmingitems.create', ['programming_id' => $programming->id, 'activity_search_id' => $pendingItem->activity_item_id]) }}" class="btn btb-flat btn-sm btn-light" title="Agregar item a la programación"><i class="fas fa-plus"></i></a>@endif</td>
        </tr>
    @php($key++)
    @endforeach
    @foreach($reviewItems as $reviewItem)
        <tr class="small">
            <td class="text-center align-middle">{{ $key }}</td>
            <td class="text-center align-middle">{{ $reviewItem->id }}</td>
            <td class="text-center align-middle">{{ $reviewItem->programItem->activityItem->int_code ?? '' }}</td>
            <td class="text-center align-middle">{{ $reviewItem->programItem->activityItem->activity_name ?? '' }}</td>
            <td class="text-center align-middle">{{ $reviewItem->programItem->activityItem->vital_cycle ?? '' }}</td>
            <td class="text-center align-middle">{{ $reviewItem->programItem->activityItem->action_type ?? '' }}</td>
            <td class="text-center align-middle">{{ $reviewItem->programItem->activityItem->def_target_population ?? '' }}</td>
            <td class="text-center align-middle">{{ $reviewItem->review }}</td>
            <td class="text-center align-middle">{{ $reviewItem->answer }}</td>
            <td class="text-center align-middle">{{ $reviewItem->observation }}</td>
            <td class="text-center align-middle">{{ $reviewItem->user->fullName ?? '' }}</td>
            @can('ProgrammingItem: evaluate')
            @if($programming->status == 'active')<td class="text-center align-middle" ><a href="{{ route('reviewItems.index', ['programmingItem_id' => $reviewItem->programItem->id]) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-clipboard-check"></i></a>@endif</td>
            @endcan
            @can('Reviews: delete')
            <td class="text-center align-middle">
                <form method="POST" action="{{ route('reviewItems.destroy', $reviewItem->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
    @php($key++)
    @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>


<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> 

<script type="text/javascript">
    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });

</script>

<script>
    function tableExcel(type, fn, dl) {
          var elt = document.getElementById('tblData');
          const filename = 'Informe_observaciones'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        }
</script>
@endsection
