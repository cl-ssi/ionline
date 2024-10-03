@extends('layouts.bt4.app')

@section('title', 'Lista de Items')

@section('content')

@include('programmings/nav')


<button onclick="tableExcel('xlsx')" class="btn btn-success float-right btn-sm">Exportar Excel</button>

<h4 class="mb-3"> Reporte actividades directas Consolidado año {{$year}}</h4>
<form method="GET" class="form-horizontal small" action="{{ route('programming.reportConsolidatedSep') }}" enctype="multipart/form-data">

    <div class="form-row">
    <div class="form-group col-md-2">
            <select name="isTracer" id="isTracer" placeholder="Es trazadora" class="form-control selectpicker" required>
                     <option value="SI" {{ $isTracer == 'SI' ? 'selected' : ''}}>Trazadoras</option>
                     <option value="NO" {{ $isTracer == 'NO' ? 'selected' : ''}}>NO trazadoras</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <select name="establishment_filter[]" id="establishment_filter" placeholder="Seleccione establecimiento" class="form-control selectpicker" required multiple data-actions-box="true">
                @foreach($establishments as $establishment)
                <option value="{{$establishment->id}}" {{ in_array($establishment->id, $options) ? 'selected' : ''}}>{{$establishment->type}} {{$establishment->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <select name="cycle_filter[]" id="cycle_filter" placeholder="Seleccione ciclo" class="form-control selectpicker" multiple data-actions-box="true">
                @foreach($cycles as $cycle)
                <option value="{{$cycle}}" {{ in_array($cycle, $cycle_selected) ? 'selected' : ''}}>{{$cycle}}</option>
                @endforeach
            </select>
        </div>
        <fieldset class="form-group col-1">
            <input type="text" class="form-control " id="datepicker" name="year" placeholder="Año" value="{{$year}}" required="">
        </fieldset>
        <button type="submit" class="btn btn-info mb-4">Generar</button>
    </div>
</form>



<table id="tblData" class="table table-striped  table-sm table-bordered table-condensed fixed_headers table-hover  ">
    <thead>
        <tr style="font-size:75%;">
            <th class="text-center align-middle" colspan="{{$isTracer == 'SI' ? 5 : 4}}">REPORTE ACTIVIDADES DIRECTAS CONSOLIDADO {{$year}}</th>
        </tr>
        <tr class="small " style="font-size:60%;">
            @if($isTracer == 'SI')<th class="text-center align-middle">Nº TRAZADORA</th>@endif
            <th class="text-center align-middle">PRESTACION O ACTIVIDAD</th>
            <th class="text-center align-middle">CICLO</th>
            <!-- <th class="text-center align-middle">PROFESIONAL</th> -->
            <th class="text-center align-middle">TOTAL ACTIVIDADES</th>
            <th class="text-center align-middle">ESTABLECIMIENTOS</th>
        </tr>
    </thead>
    <tbody style="font-size:70%;">
        @foreach($programmingItems as $programmingitem)
        <tr class="small">
            @if($isTracer == 'SI')<td class="text-center align-middle">{{ $programmingitem->int_code }}</td> @endif
            <td class="text-center align-middle">{{ $programmingitem->activity_name }}</td>
            <td class="text-center align-middle">{{ $programmingitem->vital_cycle }}</td>
            {{--<td class="text-center align-middle">{{ $programmingitem->professional }}</td>--}}
            <td class="text-center align-middle font-weight-bold">{{ number_format($programmingitem->activity_total,0, ',', '.') }}</td>
            <td class="text-left align-middle">{{ $programmingitem->establishments }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="font-size:60%;">
            <td class="text-center" colspan="{{$isTracer == 'SI' ? 3 : 2}}">TOTALES</td>
            <td class="text-center">{{ $programmingItems ? number_format($programmingItems->sum('activity_total'),0, ',', '.') : '0'}}</td>
            <td></td>
        </tr>
    </tfoot>
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
          const filename = 'Informe_consolidado'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS", raw: true});
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        }
</script>
@endsection
