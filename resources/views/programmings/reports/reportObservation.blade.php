@extends('layouts.app')

@section('title', 'Lista de Items')

@section('content')

@include('programmings/nav')


<button onclick="exportTableToExcel('tblData')" class="btn btn-success float-right btn-sm">Exportar Excel</button>

<h4 class="mb-3"> Informe de Observaciones en Programación Númerica</h4>

<!-- {{$reviewItems}} -->
<table id="tblData" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover  ">
    <thead>
        <tr style="font-size:75%;">
            <th class="text-center align-middle" colspan="7">INFORME DE OBSERVACIONES </th>
        </tr>
        <tr class="small " style="font-size:60%;">
            <th class="text-center align-middle">Nº REV.</th>
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">CICLO</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <th class="text-center align-middle">DEF. POB. OBJETIVO</th>
            <th class="text-center align-middle table-dark">EVALUACIÓN</th>
            <th class="text-center align-middle table-dark">¿SE ACEPTA?</th>
            <th class="text-center align-middle table-dark">OBSERVACIÓN</th>
            <th class="text-center align-middle table-dark">EVALUADO POR</th>
        </tr>
    </thead>
    <tbody style="font-size:70%;">
     @foreach($reviewItems as $reviewItem)
        <tr class="small">
            <td class="text-center align-middle">{{ $reviewItem->id }}</td>
            <td class="text-center align-middle">{{ $reviewItem->activity_name }}</td>
            <td class="text-center align-middle">{{ $reviewItem->cycle }}</td>
            <td class="text-center align-middle">{{ $reviewItem->action_type }}</td>
            <td class="text-center align-middle">{{ $reviewItem->def_target_population }}</td>
            <td class="text-center align-middle">{{ $reviewItem->review }}</td>
            <td class="text-center align-middle">{{ $reviewItem->answer }}</td>
            <td class="text-center align-middle">{{ $reviewItem->observation }}</td>
            <td class="text-center align-middle">{{ $reviewItem->name_rev }} {{ $reviewItem->fathers_family_rev }} {{ $reviewItem->mothers_family_rev }}</td>
            @can('ProgrammingItem: evaluate')
            <td class="text-center align-middle" ><a href="{{ route('reviewItems.index', ['programmingItem_id' => $reviewItem->id_programmingItems]) }}" class="btn btb-flat btn-sm btn-light"><i class="fas fa-clipboard-check"></i></a></td>
        @endcan
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

<script type="text/javascript">
    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });

</script>

<script>
    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        
        // Specify file name
        filename = filename?filename+'.xls':'Informe_consolidado.xls';
        
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
