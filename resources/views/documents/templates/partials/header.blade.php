
<header class="left" style="float: left;">
    @if(isset($logo_pluma))
        <img src="{{ public_path('/images/logo_pluma_'.$document->organizationalUnit->establishment->alias.'.jpg') }}" width="120" alt="Logo de la institución">
    @else
        <img src="{{ public_path('/images/logo_rgb_'.$document->organizationalUnit->establishment->alias.'.png') }}" width="120" alt="Logo de la institución">
    @endif

    @if(isset($linea1))
    <div class="siete" style="padding-top: 2px;">
        {{ $linea1 }}
    </div>
    @endif
    
    @if(isset($linea2))
    <div class="siete" style="padding-top: 1px;">
        {{ $linea2 }}
    </div>
    @endif
    
    @if(isset($linea3))
    <div class="seis" style="padding-top: 2px; color: #999">
        {{ $linea3 }}
    </div>
    @endif
</header>