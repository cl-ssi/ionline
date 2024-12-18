@extends('layouts.bt4.app')

@section('title', 'Últimos Accesos')

@section('content')

<h3 class="mb-3">Últimos Accesos</h3>

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>Ambiente</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($accessLogs as $accessLog)
            <tr>
                <td>
                    <i class="fas fa-square" style="color:
                        @switch($accessLog->enviroment)
                            @case('local') rgb(73, 17, 82); @break
                            @case('Cloud Run') rgb(2, 82, 0); @break
                            @case('Servidor') rgb(0,108,183); @break;
                            @default rgb(255,255,255); @break;
                        @endswitch
                        ">
                    </i> {{ $accessLog->enviroment }}
                </td>
                <td>
                    <a href="{{ route('rrhh.users.edit', $accessLog->user->id ?? 1) }}">
                        {{ optional($accessLog->user)->tinyName }}
                    </a>
                    @if(! optional($accessLog->user)->active)
                    <i class="fas fa-ban"></i>
                    @endif
                </td>
                <td nowrap>
                    {{ $accessLog->created_at }}
                </td>
                <td>
                    {{ $accessLog->type }}
                </td>
                <td>{{ optional($accessLog->switchUser)->tinyName }}</td>
            </tr>
            @empty

            <tr class="text-center">
                <td colspan="1">
                    <em>No hay registros</em>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $accessLogs->links() }}

@endsection

@section('custom_js')

@endsection