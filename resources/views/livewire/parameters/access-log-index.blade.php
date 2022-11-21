<div>
    @include('rrhh.submenu')

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Switch por</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accessLogs as $log)
            <tr>
                <td>{{ $log->created_at }}</td>
                <td>{{ $log->type }}</td>
                <td>{{ optional($log->switchUser)->tinnyName }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $accessLogs->links() }}
</div>
