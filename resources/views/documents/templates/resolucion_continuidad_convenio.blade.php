<html lang="es">

@include('documents.templates.partials.head', [ 
    'title' => $document->type->name . ' - ' . $document->subject,
])

<body>
    <!-- Define header and footer blocks before your content -->
    @include('documents.templates.partials.header',[
        'establishment' => $document->establishment,
        'linea3' => "ID: " . $document->id . (isset($document->internal_number) ? '- Nº Interno: '. $document->internal_number : ''),
    ])

    @include('documents.templates.partials.footer', [
        'establishment' => $document->establishment
    ])

    <!-- Define main for content -->
    <main>
        
        <div style="float: right; width: 300px; padding-top: 76px;">
            
            <div class="left quince" style="padding-left: 2px; padding-bottom: 10px;">
                <strong style="text-transform: uppercase; padding-right: 30px;">
                    RESOLUCIÓN EXENTA N°:
                </strong>
            </div>

            <div style="padding-top:5px; padding-left: 2px;">
                IQUIQUE, fecha de acuerdo a firma digital de Dirección.
            </div>

        </div>

        <div style="clear: both; padding-bottom: 36px"></div>

        <div class="content">
            {!! $document->contentHtml !!}
        </div>

        <div style="clear: both; padding-bottom: 200px"></div>

        @include('documents.templates.partials.distribution_and_responsible')

    </main>
</body>

</html>