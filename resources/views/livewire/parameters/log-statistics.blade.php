<div>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Errores</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group as $module)
            <tr>
                <td>
                    @if($module->module)
                        <a href="{{ route('parameters.logs.index', ['module' => $module->module]) }}">
                            {{ $module->module }}
                        </a>
                    @else
                        <a href="{{ route('parameters.logs.index', ['module' => 'unknown']) }}">
                            [ Modulo desconocido ]
                        </a>
                    @endif
                </td>
                <td>{{ $module->total }}</td>
            </tr>
            @endforeach
            <tr>
                <td>
                    <a href="{{ route('parameters.logs.index') }}">
                        Todos
                    </a>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
        
</div>
