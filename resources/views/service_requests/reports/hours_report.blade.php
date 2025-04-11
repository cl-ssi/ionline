@extends('layouts.bt4.app')

@section('title', 'Reporte de horas')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte de horas</h3>

<form method="GET" action="{{ route('rrhh.service-request.report.hours-report') }}">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="start_date">Fecha inicio</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date', \Carbon\Carbon::parse($startDate)->format('Y-m-d')) }}">
        </div>
        <div class="form-group col-md-3">
            <label for="end_date">Fecha fin</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date', \Carbon\Carbon::parse($endDate)->format('Y-m-d')) }}">
        </div>
        <div class="form-group col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <button type="submit" name="excel" value="1" class="btn btn-success">Exportar a Excel</button>
        </div>
    </div>
</form>

@if($reportData)
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Profesional</th>
                <th>Contrato (ServiceRequest ID)</th>
                @foreach($months as $month)
                    <th>{{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}</th>
                @endforeach
                <th>Total Horas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $data)
                <tr>
                    <td>{{ $data['employee'] }}</td>
                    <td>{{ $data['service_request_id'] }}</td>
                    @foreach($months as $month)
                        <td>{{ number_format($data['monthly_hours'][$month] ?? 0, 2) }}</td>
                    @endforeach
                    <td><strong>{{ number_format($data['total_hours'], 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mt-4">Total de horas trabajadas: <strong>{{ number_format($totalHoursOverall, 2) }}</strong></h4>
@endif

@endsection

@section('custom_js')

@endsection
