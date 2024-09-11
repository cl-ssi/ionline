@extends('layouts.bt4.app')

@section('title', 'Planilla de descuentos')

@section('content')

@include('welfare.nav')

<h3>Planilla de descuentos</h3>

<form method="GET" action="{{ route('hotel_booking.reports.discount_sheet') }}">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="year">Seleccione el año:</label>
            <select class="form-control" id="year" name="year">
                @foreach (range(\Carbon\Carbon::now()->year, \Carbon\Carbon::now()->year - 3) as $year)
                    <option value="{{ $year }}" {{ request('year', \Carbon\Carbon::now()->year) == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="month">Seleccione el mes:</label>
            <select class="form-control" id="month" name="month">
                @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('month', \Carbon\Carbon::now()->month) == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="for_status">Seleccione el tipo:</label>
            <select class="form-control" id="for_status" name="status">
                <option value="" @selected(request('status') == "")>Todos</option>
                <option value="Reservado" @selected(request('status') == "Reservado")>Reservado</option>
                <option value="Cancelado" @selected(request('status') == "Cancelado")>Anulado</option>
                <option value="Confirmado" @selected(request('status') == "Confirmado")>Confirmado</option>
            </select>
        </div>
        <div class="form-group col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </div>
</form>

<button onclick="tableExcel('xlsx')" class="btn btn-success mb-2 float-right btn-sm"><i class="fas fa-file-excel"></i> Exportar</button>
<div class="table-responsive">
    <table class="table table-bordered table-sm mt-3" id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Rut</th>
                <th>Usuario</th>
                <th>Habitación</th>
                <th>Días</th>
                <th>F.Inicio</th>
                <th>F.Fin</th>
                <th>Tipo de pago</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roomBookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td nowrap>{{ $booking->user->runFormat }}</td>
                    <td>{{ $booking->user->shortName }}</td>
                    <td>{{ $booking->room->hotel->name}} {{$booking->room->identifier }}</td>
                    <td>{{ (int) $booking->start_date->diffInDays($booking->end_date) }}</td>
                    <td nowrap>{{ $booking->start_date->format('Y-m-d') }}</td>
                    <td nowrap>{{ $booking->end_date->format('Y-m-d') }}</td>
                    <td>{{ $booking->payment_type }}</td>
                    <td>${{ $booking->room->price * (int) $booking->start_date->diffInDays($booking->end_date) }}</td>
                    <td>{{ $booking->status != "Cancelado" ? $booking->status : "Anulado" }}</td>
                    <td>{{ $booking->observation }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('custom_js')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.18.0/dist/xlsx.full.min.js"></script>
<script>
    function tableExcel(type, fn, dl) {
        var elt = document.getElementById('table');
        const filename = 'Reporte_planilla_descuentos'
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
@endsection
