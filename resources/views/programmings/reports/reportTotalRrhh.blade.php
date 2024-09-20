@extends('layouts.bt4.app')

@section('title', 'Reporte Total RRHH')

@section('content')

@include('programmings/nav')

<h4 class="mb-3">Reporte total RRHH</h4>
<form method="GET" class="form-horizontal small" action="{{ route('programming.reportTotalRrhh') }}" enctype="multipart/form-data">

    <div class="form-row">
        {{--<div class="form-group col-md-3">
            <select style="font-size:70%;" name="commune_filter" id="activity_search_id" placeholder="Tipo de Informe" class="form-control selectpicker"  required>
                    <option style="font-size:70%;" value="hospicio" {{ $option == 'hospicio' ? 'selected' : ''}}>Alto Hospicio</option>
        <option style="font-size:70%;" value="iquique" {{ $option == 'iquique' ? 'selected' : ''}}>Iquique</option>
        <option style="font-size:70%;" value="pica" {{ $option == 'pica' ? 'selected' : ''}}>Pica</option>
        <option style="font-size:70%;" value="huara" {{ $option == 'huara' ? 'selected' : ''}}>Huara</option>
        <option style="font-size:70%;" value="camiña" {{ $option == 'camiña' ? 'selected' : ''}}>Camiña</option>
        <option style="font-size:70%;" value="pozoalmonte" {{ $option == 'pozoalmonte' ? 'selected' : ''}}>Pozo Almonte</option>
        <option style="font-size:70%;" value="colchane" {{ $option == 'colchane' ? 'selected' : ''}}>Colchane</option>
        <option style="font-size:70%;" value="hectorreyno" {{ $option == 'hectorreyno' ? 'selected' : ''}}>Hector Reyno</option>
        </select>
    </div>--}}
    <div class="form-group col-md-4">
        <select name="establishment_id" id="establishment_id" class="form-control" required>
            <option value="">-- Seleccione establecimiento --</option>
            @foreach($establishments as $establishment)
            <option value="{{$establishment->id}}" {{ $establishment_id == $establishment->id ? 'selected' : ''}}>{{ $establishment->type }} {{ $establishment->name }}</option>
            @endforeach
        </select>
    </div>
    <fieldset class="form-group col-md-1">
        <input type="number" class="form-control" name="year" min="2023" max="2099" step="1" value="{{$year}}" required />
    </fieldset>
    <button type="submit" class="btn btn-info mb-4">Generar</button>
    </div>
</form>
</div> <!-- close main div -->

<div class="container-fluid">
    @if(count(request()->all()) > 0)
    <button onclick="tableExcel('xlsx')" class="btn btn-success mb-2 float-right btn-sm"><i class="fas fa-file-excel"></i> Exportar</button>
    <div class="table-responsive">
        <table id="tblData" class="table table-sm table-hover">
            <thead class="table-bordered sticky-top">
                <tr class="small">
                    <th class="text-center align-middle table-dark" rowspan="3">Funcionario/a</th>
                    <th class="text-center align-middle table-dark" colspan="12">Desde lo programado</th>
                    <th class="text-center align-middle table-dark" colspan="3">Cálculo de FINANCIAMIENTO</th>
                </tr>
                <tr class="small">
                    <th class="text-center align-middle table-dark" colspan="4">Directas</th>
                    <th class="text-center align-middle table-dark" colspan="4">Indirectas</th>
                    <th class="text-center align-middle table-dark" colspan="4">Total</th>
                    <th class="text-center align-middle table-dark" rowspan="2">Valor ($) Total Per capitadas año</th>
                    <th class="text-center align-middle table-dark" rowspan="2">Valor ($) Total PRAPS año</th>
                    <th class="text-center align-middle table-dark" rowspan="2">Valor ($) Total año</th>
                </tr>
                <tr class="small">
                    <th class="text-center align-middle table-dark">Horas/año</th>
                    <th class="text-center align-middle table-dark">Horas/día</th>
                    <th class="text-center align-middle table-dark">Jornadas directa año</th>
                    <th class="text-center align-middle table-dark">Jornada horas directa diarias</th>
                    <th class="text-center align-middle table-dark">Horas/año</th>
                    <th class="text-center align-middle table-dark">Horas/día</th>
                    <th class="text-center align-middle table-dark">Jornadas indirecta año</th>
                    <th class="text-center align-middle table-dark">Jornada horas indirecta diarias</th>
                    <th class="text-center align-middle table-dark">Horas/año</th>
                    <th class="text-center align-middle table-dark">Horas/día</th>
                    <th class="text-center align-middle table-dark">Jornadas año</th>
                    <th class="text-center align-middle table-dark">Jornada horas diarias</th>
                </tr>
            </thead>
            <tbody>
                @foreach($professionalHours as $professionalHour)
                <tr class="text-right small">
                    <td>{{ $professionalHour->alias }}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id, ['Directa'])}}">{{ number_format($programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id, ['Directa']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('hours_required_day', $professionalHour->id, ['Directa'])}}">{{ number_format($programming->getValueAcumSinceScheduled('hours_required_day', $professionalHour->id, ['Directa']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('direct_work_year', $professionalHour->id, ['Directa'])}}">{{ number_format($programming->getValueAcumSinceScheduled('direct_work_year', $professionalHour->id, ['Directa']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('direct_work_hour', $professionalHour->id, ['Directa'])}}">{{ number_format($programming->getValueAcumSinceScheduled('direct_work_hour', $professionalHour->id, ['Directa']), 5, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id, ['Indirecta'])}}">{{ number_format($programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id, ['Indirecta']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('hours_required_day', $professionalHour->id, ['Indirecta'])}}">{{ number_format($programming->getValueAcumSinceScheduled('hours_required_day', $professionalHour->id, ['Indirecta']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('direct_work_year', $professionalHour->id, ['Indirecta'])}}">{{ number_format($programming->getValueAcumSinceScheduled('direct_work_year', $professionalHour->id, ['Indirecta']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('direct_work_hour', $professionalHour->id, ['Indirecta'])}}">{{ number_format($programming->getValueAcumSinceScheduled('direct_work_hour', $professionalHour->id, ['Indirecta']), 5, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id, ['Directa','Indirecta'])}}">{{ number_format($programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id, ['Directa','Indirecta']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('hours_required_day', $professionalHour->id, ['Directa','Indirecta'])}}">{{ number_format($programming->getValueAcumSinceScheduled('hours_required_day', $professionalHour->id, ['Directa','Indirecta']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('direct_work_year', $professionalHour->id, ['Directa','Indirecta'])}}">{{ number_format($programming->getValueAcumSinceScheduled('direct_work_year', $professionalHour->id, ['Directa','Indirecta']), 2, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('direct_work_hour', $professionalHour->id, ['Directa','Indirecta'])}}">{{ number_format($programming->getValueAcumSinceScheduled('direct_work_hour', $professionalHour->id, ['Directa','Indirecta']), 5, ",", ".")}}</td>
                    <td data-v="{{$programming->getHoursYearAcumByPrapFinanced('NO', $professionalHour->id) * $professionalHour->value}}">$ {{ number_format($programming->getHoursYearAcumByPrapFinanced('NO', $professionalHour->id) * $professionalHour->value, 0, ",", ".")}}</td>
                    <td data-v="{{$programming->getHoursYearAcumByPrapFinanced('SI', $professionalHour->id) * $professionalHour->value}}">$ {{ number_format($programming->getHoursYearAcumByPrapFinanced('SI', $professionalHour->id) * $professionalHour->value, 0, ",", ".")}}</td>
                    <td data-v="{{$programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id, ['Directa','Indirecta']) * $professionalHour->value}}">$ {{ number_format($programming->getValueAcumSinceScheduled('hours_required_year', $professionalHour->id, ['Directa','Indirecta']) * $professionalHour->value, 0, ",", ".")}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

@section('custom_js')
@if($establishment_id)
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>
<script>
    function tableExcel(type, fn, dl) {
        var elt = document.getElementById('tblData');
        const filename = 'Reporte_total_RRHH_' + '{!! $programming->establishment->type !!}' + '_' + '{!! $programming->establishment->name !!}' + '_' + '{!! Carbon\Carbon::now() !!}'
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "Sheet JS", raw: false
        });
        return dl ?
            XLSX.write(wb, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            }) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
    }
</script>
@endif
@endsection