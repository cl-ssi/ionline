@extends('layouts.record')

@section('title', 'Solicitud de devolución de horas extras')

@section('linea1', 'ID: ' . $record->id)

@section('content')
    <div style="height: 130px;"></div>
    {!! $record->document_content !!}
@endsection


@section('approvals')
    <!-- Sección de las aprobaciones -->
    <div class="endorse-footer">
        @foreach ($record->endorses as $endorse)
            <div class="endorse">
                @include('sign.endorse', [
                    'approval' => $endorse,
                ])
            </div>
        @endforeach
    </div>

    @if($record->approval)
        <div class="signature-footer">
            <div class="signature" style="padding-left: 6px;"></div>
            <div class="signature" style="padding-left: 6px;">
                @include('sign.approvation', [
                    'approval' => $record->approval,
                ])
            </div>
        </div>


        <div class="signature-footer">
            {{-- <div class="signature" style="padding-left: 6px;"></div> --}}
            <div class="signature" style="padding-left: 6px;"></div>
            <div class="signature" style="padding-left: 6px;">
                @include('sign.approvation', [
                    'approval' => $record->approval,
                ])
            </div>
        </div>

    @endif
@endsection
