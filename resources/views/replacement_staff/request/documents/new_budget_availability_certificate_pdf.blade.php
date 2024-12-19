@extends('layouts.document')

@section('title', 'Certificado Disponibilidad Presupuestaria ' . $requestReplacementStaff->id)

@section('content')

    <style>
        .tabla th,
        .tabla td {
            padding: 3px;
            /* Ajusta este valor a tus necesidades */
        }

        .totales {
            margin-left: auto;
            margin-right: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .nowrap {
            white-space: nowrap;
        }
        
    </style>

    @section('linea1', 'SOLICITUD N°: '. $requestReplacementStaff->id)
    @section('linea2', 'Iquique, '. now()->format('d-m-Y H:i'))

    <div style="float: left; width: 300px; padding-top: 180px;"> </div>

    <div style="clear: both; padding-bottom: 15px; text-align: center" class="diez">
        <b>CERTIFICADO DE DISPONIBILIDAD PRESUPUESTARIA</b>
    </div>
    
    <div style="clear: both; padding-bottom: 20px">&nbsp;</div>
    
    {{--
    <div style="text-align: justify;" class="ocho">
        De conformidad a lo dispuesto en el Artículo 11 de Ley 21.516 del Ministerio de Hacienda, que aprueba el presupuesto del Sector Público 
        para el año 2024, vengo en certificar que la Dirección del Servicio de Salud Tarapacá, cuenta con presupuesto para la contratación del funcionario (a) 
        {{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->where('desist', NULL)->first()->replacementStaff->fullName }} - 
        RUT {{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->where('desist', NULL)->first()->replacementStaff->run }}-{{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->where('desist', NULL)->first()->replacementStaff->dv }} 
        que se individualiza, por el periodo {{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->where('desist', NULL)->first()->start_date->format('d-m-Y') }} - 
        {{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->where('desist', NULL)->first()->end_date->format('d-m-Y') }} 
        señalado en la presente solicitud y resolución, con cargo al subtítulo {{ $requestReplacementStaff->budgetItem->code }} - {{ $requestReplacementStaff->budgetItem->name }}.
    </div>
    --}}

    <div style="text-align: justify;" class="ocho">
        De conformidad a lo dispuesto en el Artículo 11 de Ley 21.516 del Ministerio de Hacienda, que aprueba el presupuesto del Sector Público 
        para el año 2024, vengo en certificar que la Dirección del Servicio de Salud Tarapacá, cuenta con presupuesto para la contratación del funcionario (a) 
        {{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->first()->replacementStaff->fullName }} - 
        RUT {{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->first()->replacementStaff->run }}-{{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->first()->replacementStaff->dv }} 
        que se individualiza, por el periodo {{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->first()->start_date->format('d-m-Y') }} - 
        {{ $requestReplacementStaff->technicalEvaluation->applicants->where('selected', 1)->first()->end_date->format('d-m-Y') }} 
        señalado en la presente solicitud y resolución, con cargo al subtítulo {{ $requestReplacementStaff->budgetItem->code }} - {{ $requestReplacementStaff->budgetItem->name }}.
    </div>

    <div style="clear: both; padding-bottom: 20px">&nbsp;</div>

    <div style="text-align: justify;" class="ocho">
        Que conforme el correspondiente origen de la contratación, se encuentra en trámite el proceso recuperación del Subsidio de Incapacidad Labor (SIL).
    </div>

    <div style="clear: both; padding-bottom: 20px">&nbsp;</div>

    <div style="text-align: justify;" class="ocho">
        Suscribe y Certifica,
    </div>

    <div style="clear: both; padding-bottom: 25px"></div>

    <!-- Sección de las aprobaciones -->
    <div class="signature-container">
        <div class="signature" style="padding-left: 32px;">
            @if($approvals = $requestReplacementStaff->approvals->where('position', 'left'))
                @foreach($approvals->where('subject', 'Solicitud de Aprobación Jefatura Depto. o Unidad') as $approval)
                    {{ $approval->approver->initials }} -
                @endforeach

                @foreach($requestReplacementStaff->requestSign as $sign)
                    {{ $sign->user->initials }} -
                @endforeach

                @foreach($approvals->where('subject', '!=','Solicitud de Aprobación Jefatura Depto. o Unidad') as $approval)
                    {{ $approval->approver->initials }} {{ ($approval->subject != 'Solicitud de Aprobación SDGP') ? '-' : '' }}
                @endforeach
            @endif
        </div>
        
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">

        </div>
        <div class="signature">
            @if($approvals = $requestReplacementStaff->approvals->where('position', 'right'))
                @foreach($approvals as $approval)
                    @include('sign.approvation', [
                        'approval' => $approval,
                    ])
                @endforeach
            @endif
        </div>
    </div>

@endsection
