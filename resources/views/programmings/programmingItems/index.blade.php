@extends('layouts.app')

@section('title', 'Lista de Items')

@section('content')

@include('programmings/nav')
<a href="{{ route('programmingitems.create',['programming_id' => Request::get('programming_id')]) }}" class="btn btn-info mb-4 float-right btn-sm">Agregar Item</a>
<h4 class="mb-3"> Programación - Horas Directas</h4>

<button onclick="exportTableToExcel('tblData')" class="btn btn-success mb-4 float-left btn-sm">Exportar Excel</button>

<table id="tblData" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
    <thead>
        <tr class="small " style="font-size:50%;">
            @can('ProgrammingItem: edit')<th class="text-left align-middle" ></th>@endcan
            @can('ProgrammingItem: edit')<th class="text-left align-middle" ></th>@endcan
            <th class="text-center align-middle">T</th>
            <th class="text-center align-middle">CICLO</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <!--<th class="text-center align-middle">PROGRAMA MINISTERIAL</th>-->
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
            <th class="text-center align-middle">FUENTE POBLACIÓN</th>
            <th class="text-center align-middle">N° POB. OBJETIVO</th>
            <th class="text-center align-middle">PREVALENCIA O TASA</th>
            <th class="text-center align-middle">FUENTE DE PREVALENCIA O TASA</th>
            <th class="text-center align-middle">% COBERTURA</th>
            <th class="text-center align-middle">Poblacion a Atender</th>
            <th class="text-center align-middle">CONCENTRACIÓN</th>
            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
            <th class="text-center align-middle">FUNCIONARIO  QUE OTORGA LA PRESTACIÓN</th>
            <th class="text-center align-middle">Rendimiento de la Actividad</th>
            <th class="text-center align-middle">Horas Año Requeridas</th>
            <th class="text-center align-middle">Horas Dia requeridas</th>
            <th class="text-center align-middle">Jornadas Directas Año</th>
            <th class="text-center align-middle">Jornadas Horas Directas Diarias</th>
            <th class="text-center align-middle">Fuente Informacion </th>
            <th class="text-center align-middle">FINANCIADA POR PRAP</th>
            <th class="text-center align-middle">OBSERVACIONES</th>
            @can('ProgrammingItem: delete')<th class="text-left align-middle" ></th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($programmingItems as $programmingitem)
        <tr class="small">
        @can('ProgrammingItem: edit')
            <td class="text-center align-middle" ><a href="{{ route('programmingitems.show', $programmingitem->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-clipboard-check"></i></a></td>
        @endcan
        @can('ProgrammingItem: edit')
            <td class="text-center align-middle" ><a href="{{ route('programmingitems.show', $programmingitem->id) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-edit"></i></a></td>
        @endcan
            <td class="text-center align-middle">{{ $programmingitem->tracer }}</td>
            <td class="text-center align-middle">{{ $programmingitem->cycle }}</td>
            <td class="text-center align-middle">{{ $programmingitem->action_type }}</td>
            <!--<td class="text-center align-middle">{{ $programmingitem->ministerial_program }}</td>-->
            <td class="text-center align-middle">{{ $programmingitem->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingitem->def_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingitem->prevalence_rate }}</td>
            <td class="text-center align-middle">{{ $programmingitem->source_prevalence }}</td>
            <td class="text-center align-middle">{{ $programmingitem->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingitem->population_attend }}</td>
            <td class="text-center align-middle">{{ $programmingitem->concentration }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingitem->professional }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingitem->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingitem->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingitem->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingitem->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingitem->information_source }}</td>
            <td class="text-center align-middle">{{ $programmingitem->prap_financed }}</td>
            <td class="text-center align-middle">{{ $programmingitem->observation }}</td>
            @can('ProgrammingItem: delete')
            <td class="text-center align-middle">
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingitem->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>



<h4 class="mb-3"> Programación Talleres - Horas Directas</h4>

<button onclick="exportTableToExcel('tblData')" class="btn btn-success mb-4 float-left btn-sm">Exportar Excel</button>

<table id="tblData" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover table-responsive  ">
    <thead>
        <tr class="small " style="font-size:55%;">
            <th class="text-center align-middle">TIPO</th>
            <th class="text-center align-middle">CICLO</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
            <th class="text-center align-middle">FUENTE POBLACIÓN</th>
            <th class="text-center align-middle">N° POB. OBJETIVO</th>
            <th class="text-center align-middle">% COBERTURA</th>
            <th class="text-center align-middle">Poblacion a Atender</th>

            <th class="text-center align-middle">Nº Personas por Grupo</th>
            <th class="text-center align-middle">Nº Talleres</th>
            <th class="text-center align-middle">Nº Sesiones por Taller</th>

            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
            <th class="text-center align-middle">FUNCIONARIO  QUE OTORGA LA PRESTACIÓN</th>
            <th class="text-center align-middle">Duración de Sesión en Hora</th>
            <th class="text-center align-middle">Horas Año Requeridas</th>
            <th class="text-center align-middle">Horas Dia requeridas</th>
            <th class="text-center align-middle">Jornadas Directas Año</th>
            <th class="text-center align-middle">Jornadas Horas Directas Diarias</th>
            <th class="text-center align-middle">Fuente Informacion </th>
            <th class="text-center align-middle">FINANCIADA POR PRAP</th>
            <th class="text-center align-middle">OBSERVACIONES</th>
            @can('ProgrammingItem: delete')<th class="text-left align-middle" ></th>@endcan

        </tr>
    </thead>
    <tbody style="font-size:65%;">
        @foreach($programmingItemworkshops as $programmingItemworkshop)
        <tr class="small">
            <td class="text-center align-middle">TALLER</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->cycle }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->action_type }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->def_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->source_population }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->cant_target_population }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->coverture }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->population_attend }}</td>

            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_group }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->workshop_number }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->workshop_session_number }}</td>


            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_total }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->professional }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->activity_performance }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->hours_required_year }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->hours_required_day }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->direct_work_year }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->direct_work_hour }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->information_source }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->prap_financed }}</td>
            <td class="text-center align-middle">{{ $programmingItemworkshop->observation }}</td>
            @can('ProgrammingItem: delete')
            <td>
                <form method="POST" action="{{ route('programmingitems.destroy', $programmingitem->id) }}" class="small d-inline">
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <button class="btn btn-sm btn-outline-danger small" onclick="return confirm('¿Desea eliminar el registro realmente?')">
                    <span class="fas fa-trash-alt " aria-hidden="true"></span>
                    </button>
                </form>
            </td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>


@endsection

@section('custom_js')
<script>
    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        
        // Specify file name
        filename = filename?filename+'.xls':'Actividades.xls';
        
        // Create download link element
        downloadLink = document.createElement("a");
        
        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        
            // Setting the file name
            downloadLink.download = filename;
            
            //triggering the function
            downloadLink.click();
        }
    }
</script>
@endsection
