@extends('layouts.record')

@section('title', 'Processo')

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

    
    @if($record->processType->bilateral)
        <div class="signature-footer">
            <div class="signature" style="padding-left: 50px; text-align: center;">
                ______________________________<br>
                {{ $record->municipality->name }}<br>
                &nbsp;
                <br>
            </div>
            <div class="signature" style="padding-left: 170px; text-align: center;">
                ______________________________<br>
                {{ mb_strtoupper(env('APP_SS')) }}<br>
                &nbsp;
                <br>
            </div>
        </div>
    @endif 
@endsection
