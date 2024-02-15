@extends('layouts.bt5.app')

@section('title', 'Directorio Telefónico')

@section('content')

@include('parameters.establishments.partials.nav')

<style>
    .raya_rojo {
        color: #EE3A43;
        display: inline-block;
        font-family: "Arial Black",sans-serif;
        font-size: 24.0pt;
    }
    .raya_azul {
        color: #0168B3;
        display: inline-block;
        font-family: "Arial Black",sans-serif;
        font-size: 24.0pt;
    }
</style>

<div class="row mb-3">

    <div class="col-md-7">
        <h3>Directorio Telefónico</h3>
    </div>

    <div class="col-md-5">
        <form class="form-inline" method="GET" action="{{ route('rrhh.users.directory') }}">
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="Nombre o Apellido" autocomplete="off">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </div>

</div>

<div class="row">
    <div class="col-12 col-md-7">
        @if($establishment)
            <h5>{{ $establishment->name }}</h5>
            @include('parameters.establishments.partials.outree',[
                'establishment' => $establishment,
                'route' => 'rrhh.users.directory',
            ])
        @endif
    </div>
    <div class="col-12 col-md-5">

        @foreach($users as $user)
            <address class="border p-2 mb-3">

                <span class="raya_azul">━━━</span><span class="raya_rojo">━━━━━</span><br>

                <span class="small"><strong>{{ $user->shortName }}</strong> 
                    @if($user->vc_link AND $user->vc_alias)
                    &nbsp; <a href="{{ route('vc',$user->vc_alias) }}"> <i class="fas fa-video"></i> </a>
                    @endif
                </span>

                @if($user->position)
                    <span class="text-muted small">
                        <br>
                        @if($user->position == 'Jefe' OR
                            $user->position == 'Director' OR
                            $user->position == 'Jefa' OR
                            $user->position == 'Directora')
                                {{ $user->position }}
                        @elseif($user->position != NULL)
                            <em>{{ $user->position }}</em>
                        @endif
                    </span>
                @endif
                
                @if($user->organizationalUnit)
                    <br>
                    <span class="small">{{ $user->organizationalUnit->name }}</span>
                @endif


                @foreach($user->telephones as $telephone)
                    <br>
                    <span class="small">Teléfono: <a href="tel:+56{{ $telephone->number }}">+56 {{ $telephone->number }}</a> /  
                    Anexo: {{ $telephone->minsal }}</span>
                @endforeach

                @if($user->mobile)
                    @if($user->mobile->directory)
                    <br>
                    <span class="small">Móvil: <a href="tel:+56{{ $user->mobile->number }}">+56 {{ $user->mobile->number }}</a></span>
                    @endif
                @endif

                @if($user->email)
                    <br>
                    <span class="small"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
                @endif

                <br>
                <span class="small">
                    <strong class="text-muted"><br>
                    {{ optional($user->organizationalUnit)->establishment->official_name ?? '' }}<br>
                    Gobierno de Chile
                    </strong>
                </span>

            </address>
        @endforeach

        @if($users->isNotEmpty())
            {{ $users->links() }}
        @endif
    </div>
</div>

@endsection