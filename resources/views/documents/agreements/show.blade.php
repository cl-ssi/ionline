@extends('layouts.record')

@section('title', 'Solicitud de devolución de horas extras')

@section('linea1', 'ID: ' . $record->id)

@section('content')
    <div style="height: 150px;"></div>
    {!! $record->document_content !!}
@endsection

@section('approvals')


    <!-- Sección de las aprobaciones -->
    <div class="signature-footer">
        @foreach($record->approvals as $approval)
            <div class="signature" style="padding-left: 6px;">
                @include('sign.approvation', [
                    'approval' => $approval,
                ])
            </div>
        @endforeach
    </div>
@endsection