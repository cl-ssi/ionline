FISCALÍA ADMINISTRATIVA<br>
CITACION SIMPLE<br>

<br><br>

<h3 class="text-center"><u>C I T A C I O N</u></h3>
<br>

<p>
    En Iquique, {{ now()->day }} de {{ now()->monthName }} de {{ now()->year }}.<br>
</p>

<p class="text-justify">
    Cítese a declarar en <b>{{ optional($summary->type)->name }}</b> instruido mediante 
    Resolución Exenta Nº <b>{{ $summary->resolution_number }} / {{ optional($summary->resolution_date)->year }}</b>, a
    don/doña <b>{{ $template->nombre ?? '' }}</b> , el día 
    <b>{{ $template->fecha ?? '' }}</b> en <b>{{ $template->ubicacion ?? '' }}</b>.
</p>

<br>
<br>
<div class="row">
    <div class="col text-center">
        <br><br>
        {{ optional($summary->actuary)->shortName }}<br>
        A C T U A R I O
    </div>
    <div class="col text-center">
        {{ optional($summary->investigator)->shortName }}<br>
        <b>F I S C A L</b>
    </div>
</div>

<br><br><br><br><br>

<div class="row">
    <div class="col">
        NOTIFICADO EL: ___ / ____ / ________
    </div>
    <div class="col text-center">
        F I R M A : 
    </div>
</div>