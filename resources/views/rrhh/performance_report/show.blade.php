@extends('layouts.document')
@section('content')
    <div class="center diez">
        <strong style="text-transform: uppercase;">
                INFORME DE DESEMPEÑO
        </strong>
    </div>

    {{--

    <!-- Sección de las aprobaciones -->
    <!-- <div class="signature-container">
        <div class="signature" style="padding-left: 32px;">
            @if($approval = $reception->approvals->where('position', 'left')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">
            @if($approval = $reception->approvals->where('position', 'center')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
        <div class="signature">
            @if($approval = $reception->approvals->where('position', 'right')->first())
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            @endif
        </div>
    </div> -->
    --}}

@endsection