<table class="table table-sm">
    <thead>
    <tr>
        <th>Horas Diurno</th>
        <th>Horas Nocturno</th>
        <th>Horas Total</th>
        <th>Monto</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$totalHoursDay}}</td>
            <td>{{$totalHoursNight}}</td>
            <td>{{$totalHours}}</td>
            <td>{{ '$'.number_format($totalAmount, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>
