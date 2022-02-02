@extends('layouts.report')

@section('title', 'Certificado de Idoneidad')

@section('content')
<div class="siete" style="padding-top: 3px;">
    Depto. Gestión de Recursos Humanos
</div>

<div class="seis" style="padding-top: 4px; color: #999">
    Código de Solicitud de Idoneidad Interno: {{ $result->psirequest->id ?? ''  }}    
</div>

<div id="titulo">
    <div class="center" style="width: 100%;">
        <p class="uppercase" style="font-weight:bold; font-size:22px;">
        INFORME DE IDONEIDAD PSICOLÓGICA<br>
        PARA DESEMPEÑAR EL CARGO DE<br>
        ASISTENTE A LA EDUCACIÓN<br>
        LEY N° 21.109
        </p>
    </div>
</div>

<div style="border-top: 1px solid #CCC; margin: 15px 0px 15px;"></div>
<p class="justify" style="font-size:18px; line-height:150%;">
    El Subdirector de Gestión y Desarrollo de las Personas que suscribe, certifica que se realizó a <strong>{{ $result->user->fullName ?? ''  }}, Rut:{{ $result->user->id ?? ''  }}-{{ $result->user->dv ?? ''  }} </strong>
    evaluaciones psicológicas, en su calidad de postulante al cargo de Asistente de la Educación en el Establecimiento <strong>{{ $result->psirequest->school->name ?? ''  }} (RBD:{{ $result->psirequest->school->rbd ?? ''  }})</strong>, según lo dispone el Parrafo 1 del Artículo 4 de la ley
    21.109
</p>
<br>
<br>
<br>
<p class="justify" style="font-size:18px; line-height:150%;">
    De acuerdo al resultado de esta evaluación, la persona obtiene la categoría de:<strong>IDONEO</strong>,
    para desempeñarse como Asistente de la Educación en el citado establecimiento, según el
    perfil de cargo establecido para dicha función
</p>

{{ env('APP_SS') }}
@endsection