@extends('layouts.app')

@section('title', 'Lista de Items')

@section('content')

@include('programmings/nav')


<button onclick="exportTableToExcel('tblData')" class="btn btn-success float-right btn-sm">Exportar Excel</button>

<h4 class="mb-3"> Informe Consolidado</h4>
<form method="GET" class="form-horizontal small" action="{{ route('programming.reportConsolidated') }}" enctype="multipart/form-data">

    <div class="form-row">
        <div class="form-group col-md-3">
            <select style="font-size:70%;" name="commune_filter" id="activity_search_id" placeholder="Tipo de Informe" class="form-control selectpicker"  required>
                     <option style="font-size:70%;" value="hospicio">Alto Hospicio</option>
                     <option style="font-size:70%;" value="iquique">Iquique</option>
                     <option style="font-size:70%;" value="pica">Pica</option>
                     <option style="font-size:70%;" value="huara">Huara</option>
                     <option style="font-size:70%;" value="camiña">Camiña</option>
                     <option style="font-size:70%;" value="pozoalmonte">Pozo Almonte</option>
                     <option style="font-size:70%;" value="colchane">Colchane</option>
                     <option style="font-size:70%;" value="hectorreyno">Hector Reyno</option>
            </select>
        </div>
        <fieldset class="form-group col-2">
            <input type="text" class="form-control " id="datepicker" name="year" placeholder="Año" required="">
        </fieldset>
        <button type="submit" class="btn btn-info mb-4">Generar</button>
    </div>
</form>



<table id="tblData" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover  ">
    <thead>
        <tr style="font-size:75%;">
            <th class="text-center align-middle" colspan="4">INFORME CONSOLIDADO</th>
        </tr>
        <tr class="small " style="font-size:60%;">
            <th class="text-center align-middle">Nº TRAZADORA</th>
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">ACCIÓN</th>
            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
        </tr>
    </thead>
    <tbody style="font-size:70%;">
        @foreach($programmingItems as $programmingitem)
        <tr class="small">
            <td class="text-center align-middle">{{ $programmingitem->int_code }}</td>
            <td class="text-center align-middle">{{ $programmingitem->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingitem->action_type }}</td>
            <td class="text-center align-middle">{{ number_format($programmingitem->activity_total,0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="font-size:60%;">
            <td class="text-center" colspan="3">TOTALES</td>
            <td class="text-center">{{ $programmingItems ? number_format($programmingItems->sum('activity_total'),0, ',', '.') : '0'}}</td>
        </tr>
    </tfoot>
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
