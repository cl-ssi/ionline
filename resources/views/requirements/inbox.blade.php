@extends('layouts.app')

@section('title', 'Requerimientos')

@section('content')

@include('requirements.partials.nav')

<div class="alert alert-info" role="alert">
    Recuerda siempre cerrar los requerimientos y archivarlos si ya están terminados.
</div>

@livewire('requirements.filter',[$user])

<div class="row">

    <div class="col">
        <h3 class="mb-3">
        @if(request()->has('archived'))
            Archivados
        @else
            Pendientes por atender
        @endif
        </h3>
    </div>

    <div class="col">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link {{ ($user->id == auth()->id())?'disabled':'' }}" 
                    href="{{ route('requirements.inbox',auth()->user()) }}">
                    {{ auth()->user()->tinnyName }}
                </a> 
            </li>
            @foreach($allowed_users as $allowed)
            <li class="nav-item">
                <a class="nav-link {{ ($user == $allowed)?'disabled':'' }}" 
                    href="{{ route('requirements.inbox',$allowed) }}">
                    {{ $allowed->tinnyName }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

</div>



<table class="table table-sm table-bordered">
    <tr>
        <td class="alert-light text-center">Recibidos ({{ $counters['created'] }})</td>
        <td class="alert-warning text-center">Respondidos ({{ $counters['replyed'] }})</td>
        <td class="alert-primary text-center">Derivados ({{ $counters['derived'] }})</td>
        <td class="alert-success text-center">Cerrados ({{ $counters['closed'] }})</td>
        <td class="alert-secondary text-center">En copia</td>
        <td class="alert-light text-center">
            <a href="{{ route('requirements.inbox',$user) }}" class="btn-link {{ request()->has('archived') ? '':'disabled' }}">
                Pendientes ({{ $requirements->total() }})
            </a>
        </td>
        <td class="alert-light text-center">
            <a href="{{ route('requirements.inbox',$user) }}?archived=true" class="btn-link {{ request()->has('archived') ? 'disabled':'' }}">
                Archivados ({{ $counters['archived'] }})
            </a>
        </td>
        <td>
            <!-- <a href="{{ route('requirements.inbox',$user) }}?unreadedEvents=false" class="btn btn-sm btn-light">
                <i class="fas fa-envelope"></i> <span class='badge badge-secondary'></span>
            </a> -->
            <a href="{{ route('requirements.inbox',$user) }}?unreadedEvents=true" class="btn btn-sm btn-success">
                <i class="fas fa-envelope"></i> <span class='badge badge-secondary'>º</span>
            </a>
        </td>
    </tr>
</table>


@include('requirements.partials.list')


{{ $requirements->links() }}


@endsection

@section('custom_js')

@endsection
