@extends('layouts.bt5.app')

@section('title', 'Mis Notificaciones')

@section('content')

    <div class="row">
        <div class="col-sm-5">
            <h4 class="mb-3"><i class="fas fa-bell" title="Notificaciones"></i> Mis Notificaciones</h4>
        </div>
    </div>

    <br />

    <a class="btn btn-warning mb-3" href="/clear-notifications">
        <i class="fas fa-trash"></i>
        Marcar todas las notificaciones como leídas
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm small">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>Fecha</th>
                    <th>Módulo iOnline</th>
                    <th>Asunto</th>
                    <th>Leído / Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach (auth()->user()->notifications()->paginate(20) as $notification)
                    <tr class="{{ $notification->read_at ? 'table-success' : '' }}">
                        <td>{{ $notification->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <i class="{{ explode('-',$notification->data['icon'] ?? null)[0] }} {{ $notification->data['icon'] ?? null }}"></i>
                            {{-- {!! $notification->data['icon'] ?? null !!} --}}
                            {{ $notification->data['title'] ?? '' }}
                        </td>
                        <td>
                            @if (isset($notification->data['subject']))
                                {{-- Mostrar el formato antiguo --}}
                                {!! $notification->data['subject'] !!}
                            @elseif(isset($notification->data['body']))
                                {{-- Mostrar el formato nuevo --}}
                                {!! $notification->data['body'] !!}
                            @elseif(isset($notification->data['message']))
                                {{-- Fallback adicional para mensajes genéricos --}}
                                {!! $notification->data['message'] !!}
                            @else
                                Sin detalles disponibles
                            @endif
                        </td>
                        <td>
                            {{ $notification->read_at ? $notification->read_at->format('d-m-Y H:i:s') : '' }}
                        </td>
                        <td>
                            <a class="btn btn-outline-secondary btn-sm"
                                href="{{ route('openNotification', $notification) }}" title="Ir">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ auth()->user()->notifications()->paginate(20)->links() }}
    </div>

@endsection

@section('custom_js')

@endsection
