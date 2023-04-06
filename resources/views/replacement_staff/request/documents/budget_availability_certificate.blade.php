@extends('replacement_staff.request.documents.layouts')

@section('title', "Certificado de Disponibilidad Presupuestaria")

@section('content')

<div style="width: 49%; display: inline-block;">
    <div class="siete">
        Servicio de Salud Iquique
    </div>
</div>

<div style="clear: both; padding-bottom: 20px">&nbsp;</div>

<div style="clear: both; padding-bottom: 15px; text-align: center"><b>CERTIFICADO DE DISPONIBILIDAD PRESUPUESTARIA</b></div>

<div style="clear: both; padding-bottom: 20px">&nbsp;</div>

<div style="text-align: justify;">
    De conformidad a lo dispuesto en el Artículo 11 de Ley 21.516 del Ministerio de Hacienda, 
    que aprueba el presupuesto del Sector Público para el año 2023, vengo en certificar que la 
    Dirección del Servicio de Salud Iquique, cuenta con presupuesto para la contratación del 
    funcionario (a) que se individualiza, por el periodo señalado en la presente solicitud y resolución, 
    con cargo al subtítulo <u>{{ $requestReplacementStaff->budgetItem->code }}, {{ $requestReplacementStaff->budgetItem->name }}</u>.
</div>

<div style="clear: both; padding-bottom: 20px">&nbsp;</div>

<div style="text-align: justify;">
    Que conforme el correspondiente origen de la contratación, se encuentra en trámite el proceso recuperación 
    del Subsidio de Incapacidad Labor (SIL).
</div>

<div style="clear: both; padding-bottom: 20px">&nbsp;</div>

<div style="text-align: justify;">
    Suscribe y Certifica,
</div>

@endsection