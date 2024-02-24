<div>
    <h3>Secciones 2024</h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Serie</th>
                <th>Nserie</th>
                <th>Supergroups</th>
                <th>Supergroups Inline</th>
                <th>Discard Group</th>
                <th>Totals</th>
                <th>Totals By Prestacion</th>
                <th>Totals By Group</th>
                <th>Totals First</th>
                <th>Subtotals</th>
                <th>Subtotals First</th>
                <th>Tfoot</th>
                <th>Precision</th>
                <th></th>
            </tr>

        </thead>
        <tbody>
            @foreach($secciones as $seccion)
            <tr>
                <td>{{ $seccion->name }}</td>
                <td>{{ $seccion->serie }}</td>
                <td>{{ $seccion->nserie }}</td>
                <td>{{ $seccion->supergroups }}</td>
                <td>{{ $seccion->supergroups_inline }}</td>
                <td>{{ $seccion->discard_group }}</td>
                <td>{{ $seccion->totals }}</td>
                <td>{{ $seccion->totals_by_prestacion }}</td>
                <td>{{ $seccion->totals_by_group }}</td>
                <td>{{ $seccion->totals_first }}</td>
                <td>{{ $seccion->subtotals }}</td>
                <td>{{ $seccion->subtotals_first }}</td>
                <td>{{ $seccion->tfoot }}</td>
                <td>{{ $seccion->precision }}</td>
                <td>
                    <a href="{{ route('indicators.rem.generator', $seccion) }}" class="btn btn-primary btn-sm">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
