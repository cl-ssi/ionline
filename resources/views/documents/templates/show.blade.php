<html lang="es">

@include('documents.templates.partials.head', [ 
    'title' => $document->type->name . ' - ' . $document->subject,
])

<body>
    <!-- Define header and footer blocks before your content -->
    @include('documents.templates.partials.header', [
        'establishment' => $document->establishment,
        'linea3' => "ID: " . $document->id . (isset($document->internal_number) ? '- Nº Interno: '. $document->internal_number : ''),
    ])

    @include('documents.templates.partials.footer', [
        'establishment' => $document->establishment
    ])

    <!-- Define main for content -->
    <main>

        <div style="float: right; width: 300px; padding-top: 66px;">
            
            <div class="left quince" style="padding-left: 2px; padding-bottom: 10px;">
                <strong style="text-transform: uppercase; padding-right: 30px;">
                    {{ optional($document->type)->name }} {{ $document->reserved ? 'Reservado' : '' }} N°:
                </strong> 
                <span class="catorce negrita">{{ $document->number }}</span>
            </div>

            <table>
                @if($document->antecedent)
                <tr>
                    <td class="left negrita" style="vertical-align: top;">ANT:</td>
                    <td>{{ $document->antecedent }}</td>
                </tr>
                @endif
                
                <tr>
                    <td class="left negrita" style="vertical-align: top;">MAT:</td>
                    <td>{{ $document->subject }}</td>
                </tr>
            </table>

            @if($document->date AND $document->type->name != 'Oficio')
            <div style="padding-top:5px; padding-left: 2px;">
                Iquique, {{ $document->date->day }} de {{ $document->date->monthName }} del {{ $document->date->year }}
            </div>
            @endif

        </div>

        <div style="clear: both; padding-bottom: 25px"></div>

        @switch($document->greater_hierarchy)
            @case('from')
                <div style="width: 60px; float:left;"><strong>DE:</strong></div>
                <div style="weight: bold;float:left; text-transform: uppercase;"><strong>{!! $document->fromHtml !!}</strong></div>
                <div style="clear: both; padding-bottom: 10px"></div>

                <div style="width: 60px; float:left;"><strong>PARA:</strong></div>
                <div style="weight: bold; float:left; text-transform: uppercase;"><strong>{!! $document->forHtml !!}</strong></div>
                <div style="clear: both"></div>
            @break

            @case('for')
                <div style="width: 60px; float:left;"><strong>PARA:</strong></div>
                <div style="weight: bold; float:left; text-transform: uppercase;"><strong>{!! $document->forHtml !!}</strong></div>
                <div style="clear: both; padding-bottom: 10px"></div>

                <div style="width: 60px; float:left;"><strong>DE:</strong></div>
                <div style="weight: bold;float:left; text-transform: uppercase;"><strong>{!! $document->fromHtml !!}</strong></div>
                <div style="clear: both"></div>
            @break

        @endswitch


        <div style="border-top: 1px solid #CCC; margin: 14px 0px 14px;"></div>
        <div class="content">
            {!! $document->contentHtml !!}
        </div>

        @include('documents.templates.partials.distribution_and_responsible')

    </main>

</body>

</html>