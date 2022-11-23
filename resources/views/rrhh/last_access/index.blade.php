@extends('layouts.app')

@section('title', 'Últimos Accesos')

@section('content')

<h3 class="mb-3">Últimos Accesos</h3>

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accessLogs as $accessLog)
            <tr>
                <td>
                    <a href="{{ route('rrhh.users.service_requests.edit',$accessLog->user->id) }}">
                        {{ $accessLog->user->name }}
                    </a>
                    @if(!$accessLog->user->active)
                    <i class="fas fa-ban"></i>
                    @endif
                </td>
                <td nowrap>
                    {{ $accessLog->created_at }}
                </td>
                <td>
                    {{ $accessLog->type }}
                </td>
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

@endsection

@section('custom_js')

@endsection