<div>
    @include('rrhh.submenu')

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Env</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Switch por</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accessLogs as $log)
            <tr>
                <td>
                    <i class="fas fa-square" style="color:
                        @switch($log->enviroment)
                            @case('local') rgb(73, 17, 82); @break
                            @case('Cloud Run') rgb(2, 82, 0); @break
                            @case('Servidor') rgb(0,108,183); @break;
                            @default rgb(255,255,255); @break;
                        @endswitch
                        ">
                    </i> {{ $log->enviroment }}
                </td>
                <td>{{ $log->created_at }}</td>
                <td>{{ $log->type }}</td>
                <td>{{ optional($log->switchUser)->tinyName }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $accessLogs->links() }}
</div>
