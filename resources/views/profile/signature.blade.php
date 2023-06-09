@extends('layouts.app')

@section('title', 'Firma de correo')

@section('content')

<h3 class="mb-3">Firma de correo</h3>

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

@php($user = auth()->user())

<strong>Ejemplo de firma 1</strong>
<address class="border p-2 mb-3">
Estimado {{ auth()->user()->shortName }}<br><br>
El presente correo electrónico es para lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut est sint iure minus accusantium quidem, eligendi in aut ab tempore nihil, modi iusto quasi. Tempora asperiores quas rem libero iusto?
Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis deleniti, aspernatur, autem pariatur dolores magni, soluta fugiat nostrum omnis voluptatum voluptas ipsum ut dolore eum libero! Accusantium odio omnis ipsam.
Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt nostrum ratione repellendus dolor, eligendi necessitatibus saepe odit, illum, voluptatum eaque odio culpa minus nisi ullam voluptatem perferendis error labore expedita.
<br><br>
<div class="row">
    <div class="ml-3 mr-3" >
        <img src="/images/logo_sst_150px.png" 
            width="150" 
            alt="Logo Vacuna Dupla Influenza y Covid19">
        <img src="/images/firma_camp.png" 
            width="136" 
            alt="Logo Vacuna Dupla Influenza y Covid19">
    </div>
    <div class="">
        <span class="small">
            <strong>{{ $user->shortName }}</strong>
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

        @if($user->email)
            <br>
            <span class="small"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
        @endif

        <br>
    </div>
</div>


</address>

<br><br><br>




<strong>Ejemplo de firma 2</strong>
<address class="border p-2 mb-3">
Estimado {{ auth()->user()->shortName }}<br><br>
El presente correo electrónico es para lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut est sint iure minus accusantium quidem, eligendi in aut ab tempore nihil, modi iusto quasi. Tempora asperiores quas rem libero iusto?
Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis deleniti, aspernatur, autem pariatur dolores magni, soluta fugiat nostrum omnis voluptatum voluptas ipsum ut dolore eum libero! Accusantium odio omnis ipsam.
Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt nostrum ratione repellendus dolor, eligendi necessitatibus saepe odit, illum, voluptatum eaque odio culpa minus nisi ullam voluptatem perferendis error labore expedita.
<br><br>
<div class="row">
    <div class="ml-3 mr-3 mt-4" >
        <img src="/images/firma_camp.png" 
            width="190" 
            alt="Logo Vacuna Dupla Influenza y Covid19">
    </div>
    <div class="">
        <span class="raya_azul">━━━</span><span class="raya_rojo">━━━━━</span><br>
        <span class="small">
            <strong>{{ $user->shortName }}</strong>
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

        @if($user->email)
            <br>
            <span class="small"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
        @endif


        <span class="small">
        <strong class="text-muted"><br>
        {{ optional($user->organizationalUnit)->establishment->official_name ?? '' }}<br>
        Gobierno de Chile
        </strong>
    </span>
        <br>
    </div>
</div>


</address>



<br><br><br>




<strong>Formato de firma del Gobierno (kitdigital)</strong>
<address class="border p-2 mb-3">

Estimado {{ auth()->user()->shortName }}<br><br>
El presente correo electrónico es para lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut est sint iure minus accusantium quidem, eligendi in aut ab tempore nihil, modi iusto quasi. Tempora asperiores quas rem libero iusto?
Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis deleniti, aspernatur, autem pariatur dolores magni, soluta fugiat nostrum omnis voluptatum voluptas ipsum ut dolore eum libero! Accusantium odio omnis ipsam.
Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt nostrum ratione repellendus dolor, eligendi necessitatibus saepe odit, illum, voluptatum eaque odio culpa minus nisi ullam voluptatem perferendis error labore expedita.
<br><br>

    <span class="raya_azul">━━━</span><span class="raya_rojo">━━━━━</span><br>

    <span class="small">
        <strong>{{ $user->shortName }}</strong>
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









@endsection