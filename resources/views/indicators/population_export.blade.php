<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Centro</th>
                <th>Comuna</th>
                <th>Edad</th>
                <th>Sexo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exports as $export)
            <tr>
                <td>{{ $export->NOMBRE_CENTRO }}</td>
                <td>{{ $export->comuna }}</td>
                <td>{{ $export->EDAD }}</td>
                <td>{{ $export->GENERO }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>