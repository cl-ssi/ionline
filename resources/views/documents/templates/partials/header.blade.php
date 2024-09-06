
<header class="left" style="float: left;">

    {{--
        /**
         * Parámetros del include:
         **/
        // @include('documents.templates.partials.header', [
        //   'establishment' => $document->organizationalUnit->establishment, // Obligatorio
        //   'logo_pluma' => true or false, // Opcional
        //   'linea1' => 'Ej: Establecimiento', // Opcional
        //   'linea2' => 'Ej: Unidad organizacional', // Opcional
        //   'linea3' => 'Ej: Nº Interno: '. $document->internal_number : '') // opcional,
        // ]);

        /** Confeccionar URL pública del logo */
        /** 
         * El código está acá para poder reutilizar este include en otro documento
         * EJ:  
         * '/images/logo_rgb_SSI.png'
         * '/images/logo_pluma_SSI_HAH.png'
         **/
    --}}

    @php
        $logo = '/images/logo_';

        if(isset($logo_pluma)) {
            $logo .= 'pluma_';
        }
        else {
            $logo .= 'rgb_';
        }

        if($establishment->mother) {
            $logo .= $establishment->mother->alias . '_';
        }

        $logo .= $establishment->alias . '.png';
    @endphp 


    <img src="{{ public_path($logo) }}" 
        height="109" 
        alt="Logo de la institución">

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