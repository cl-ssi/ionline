<div>
    <h3>Secciones 2024</h3>

    @include('indicators.rem.partials.admin.nav')

    @foreach($columnas as $columna)
        <a href="{{ route('indicators.rem.admin.seccion', $columna) }}" class="btn btn-outline-primary btn-sm">{{ $columna['nserie'] }}</a>
    @endforeach

    <table class="table table-sm table-bordered mt-3">
        <thead>
            <tr>
                <th>Nserie</th>
                <th>Sección</th>
                <th>Supergroups Inline</th>
                <th>Discard Group</th>
                <th>Totals</th>
                <th>Totals First</th>
                <th>Subtotals First</th>
                <th>Tfoot</th>
                <th>Precision</th>
                <th></th>
            </tr>

        </thead>
        <tbody>
            @foreach($secciones as $seccion)
            <tr>
                <td>{{ $seccion->nserie }}</td>
                <td>Sección {{ $seccion->name }}</td>
                <td>{{ $seccion->supergroups_inline }}</td>
                <td>{{ $seccion->discard_group }}</td>
                <td>{{ $seccion->totals }}</td>
                <td>{{ $seccion->totals_first }}</td>
                <td>{{ $seccion->subtotals_first }}</td>
                <td>{{ isset($seccion->tfoot) ? 'SI' : '' }}</td>
                <td>{{ $seccion->precision }}</td>
                <td>
                    <a href="{{ route('indicators.rem.admin.generator', $seccion) }}" class="btn btn-primary btn-sm">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
