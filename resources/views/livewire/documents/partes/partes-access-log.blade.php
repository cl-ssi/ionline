<div>
    @include('documents.partes.partials.nav')

    <h3 class="mb-3">Usuarios con acceso a partes de tu mismo establecimiento</h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Run</th>
                <th>Usuario</th>
                <th>Unidad Organizacional</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user )
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->shortName }}</td>
                <td>{{ $user->organizationalUnit->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mb-3">Ultimos accesos a partes ({{ $daysAgo }} días)</h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Fecha de acceso</th>
                <th>Usuario</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($lastLogs as $log )
            <tr>
                <td>{{ $log->created_at }}</td>
                <td>{{ $log->user->shortName }} @if($log->user->deleted_at) <b>Eliminado</b> @endif</td>
                <td>{{ $log->switch_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
        
</div>