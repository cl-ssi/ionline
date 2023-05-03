<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Comuna</th>
        <th>RTP</th>
        <th>DAP</th>
        <th>DAJ</th>
        <th>DGF</th>
        <th>SDGA</th>
        <th>Comuna</th>
        <th>Director/a</th>
        <th>Res. N°</th>
        <th>Monto total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($agreements as $agreement)
        @php
        $components = [];
        $montoTotal = 0;
        foreach($agreement->agreement_amounts as $amount){
            $montoTotal += $amount->amount;
            if($amount->amount != 0)
                $components[] = $amount->program_component->name;
        }
        @endphp
        <tr>
            <td>{{ $agreement->id }}</td>
            <td>{{ $agreement->program->name.($components ? ' ('.implode(', ', $components).')' : '') ?? 'Retiro voluntario' }}</td>
            <td>{{ $agreement->commune->name }}</td>
            <td>{{ $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(1) : ($agreement->stages->where('type', 'RTP')->where('group', 'CON')->first()->dateEndText ?? 'En espera') }}</td>
            <td>{{ $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(2) : ($agreement->stages->where('type', 'DAP')->where('group', 'CON')->first()->dateEndText ?? 'En espera') }}</td>
            <td>{{ $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(3) : ($agreement->stages->where('type', 'DAJ')->where('group', 'CON')->first()->dateEndText ?? 'En espera') }}</td>
            <td>{{ $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(4) : ($agreement->stages->where('type', 'DGF')->where('group', 'CON')->first()->dateEndText ?? 'En espera') }}</td>
            <td>{{ $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(5) : ($agreement->stages->where('type', 'SDGA')->where('group', 'CON')->first()->dateEndText ?? 'En espera') }}</td>
            <td>{{ $agreement->stages->where('type', 'Comuna')->where('group', 'CON')->first()->dateEndText ?? 'En espera' }}</td>
            <td>{{ $agreement->file_to_sign_id ? $agreement->getSignObservation() : ($agreement->stages->where('type', 'Director')->where('group', 'CON')->first()->dateEndText ?? 'En espera') }}</td>
            <td>{{ $agreement->res_exempt_number }}</td>
            <td>{{ $montoTotal > 0  ? $montoTotal : $agreement->total_amount }}</td>
        </tr>
        @foreach($agreement->addendums as $addendum)
        <tr>
            <td></td>
            <td>Incluye addendum #{{$addendum->id}}</td>
            <td></td>
            <td>{{ $addendum->file_to_endorse_id ? $addendum->getEndorseObservationBySignPos(1) : 'En espera' }}</td>
            <td>{{ $addendum->file_to_endorse_id ? $addendum->getEndorseObservationBySignPos(2) : 'En espera' }}</td>
            <td>{{ $addendum->file_to_endorse_id ? $addendum->getEndorseObservationBySignPos(3) : 'En espera' }}</td>
            <td>{{ $addendum->file_to_endorse_id ? $addendum->getEndorseObservationBySignPos(4) : 'En espera' }}</td>
            <td>{{ $addendum->file_to_endorse_id ? $addendum->getEndorseObservationBySignPos(5) : 'En espera' }}</td>
            <td></td>
            <td>{{ $addendum->file_to_sign_id ? $addendum->getSignObservation() : 'En espera' }}</td>
            <td>{{ $addendum->res_number }}</td>
            <td></td>
        </tr>
        @endforeach
    @endforeach
    </tbody>
</table>