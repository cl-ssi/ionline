@extends('layouts.bt4.app')

@section('content')

@livewire('prof-agenda.reports.clinical-record-report',['patient' => $patient])

@endsection

@section('custom_js')

@endsection
