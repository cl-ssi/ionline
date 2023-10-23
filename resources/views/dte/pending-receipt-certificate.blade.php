@extends('layouts.bt4.app')
@section('title', 'DTEs pendientes de Asignar DTE')
@section('content')
    @include('dte.pendingnav')
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th>FR</th>
                <th>Tipo de {{ $tray }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
                <tr>
                    <td>{{ $dte->id }}</td>
                    <td>
                        @include('finance.payments.partials.dte-info')
                    </td>
                    <td>
                        @include('finance.payments.partials.fr-info')
                    </td>
                    <td>
                    {{ $dte->requestForm->subtype }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
