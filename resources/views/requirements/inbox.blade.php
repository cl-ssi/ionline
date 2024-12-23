@extends('layouts.bt4.app')

@section('title', 'Requerimientos')

@section('content')

@include('requirements.partials.nav')



<div class="row">

    <div class="col-7">
        <h3 class="mb-3">
           Requerimientos de {{ $user->tinyName }}
        </h3>
    </div>

    <div class="col">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link {{ ($user->id == auth()->id())?'disabled':'' }}" 
                    href="{{ route('requirements.inbox',auth()->user()) }}">
                    {{ auth()->user()->tinyName }}
                </a> 
            </li>
            @foreach($allowed_users as $allowed)
            <li class="nav-item">
                <a class="nav-link {{ ($user == $allowed)?'disabled':'' }}" 
                    href="{{ route('requirements.inbox',$allowed) }}">
                    {{ $allowed->tinyName }}
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
        <td class="alert-light text-center">Pendientes ({{ $counters['pending'] }})</td>
        <td class="alert-light text-center">Archivados ({{ $counters['archived'] }})</td>
    </tr>
</table>


@livewire('requirements.filter',['user'=> $user, 'auth_user' => $auth_user])


@endsection

@section('custom_js')

@endsection
