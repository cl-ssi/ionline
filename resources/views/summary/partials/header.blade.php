<table class="table table-sm table-bordered">
    <tbody>
        <tr>
            <th>Estado</th>
            <td>
                {{ $summary->lastEvent?->type->name }} ({{ (int) $summary->start_at->diffInDays(now()) }} días)</td>
            </td>
        </tr>
        <tr>
            <th>Resolución</th>
            <td>
                {{ $summary->resolution_number }} /
                {{ optional($summary->resolution_date)->format('Y-m-d') }}</td>
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
                @livewire('summary.update-observation', ['summary' => $summary])
            </td>
        </tr>
    </tbody>
</table>
