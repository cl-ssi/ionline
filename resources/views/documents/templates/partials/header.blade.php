
<header class="left" style="float: left;">
    @if(isset($logo_pluma))
        <img src="{{ public_path('/images/logo_pluma_'.$document->organizationalUnit->establishment->alias.'.jpg') }}" width="120" alt="Logo de la institución">
    @else
        <img src="{{ public_path('/images/logo_rgb_'.$document->organizationalUnit->establishment->alias.'.png') }}" width="120" alt="Logo de la institución">
    @endif

    <div class="siete" style="padding-top: 2px;">
        {{ $document->organizationalUnit->establishment->name }}
    </div>
    
    @if(isset($organizationalUnit))
    <div class="siete" style="padding-top: 1px;">
        {{ $organizationalUnit->name }}
    </div>
    @endif
    
    <div class="seis" style="padding-top: 2px; color: #999">
        ID: {{ $document->id }}
        
        @if ($document->internal_number)
            - Nº Interno: {{ $document->internal_number }}
        @endif
    </div>
</header>