<table class="table table-sm">
    <thead>
    <tr>
        <th>Total de Horas</th>
    </tr>
    </thead>
    <tbody>
    @foreach($serviceRequest->shiftControls as $key => $shiftControl)
        <tr>

            <td>{{Carbon\Carbon::parse($shiftControl->start_date)->diffInHours($shiftControl->end_date)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
