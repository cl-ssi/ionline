<table class="table table-sm table-bordered">
    <tbody>
        <tr>
            <th>Estado</th>
            <td>{{ $summary->status ?? '' }} (3 días)
            </td>
        </tr>
        <tr>
            <th>Fecha inicio</th>
            <td>{{ $summary->start_at ?? '' }}</td>
        </tr>
        <tr>
            <th>Fecha término</th>
            <td>{{ $summary->end_at ?? '' }}</td>
        </tr>
        <tr>
            <th>Fiscal</th>
            <td>{{ $summary->investigator->shortName ?? '' }}</td>
        </tr>
        <tr>
            <th>Actuario</th>
            <td>{{ $summary->actuary->shortName ?? '' }}</td>
        </tr>
        <tr>
            <th>Observaciones</th>
            <td>
                <textarea class="form-control" cols="30" rows="4">{{ $summary->observation }}</textarea>
                <button type="button" class="btn btn-primary float-right mt-2">Actualizar</button>
            </td>
        </tr>
    </tbody>
</table>
