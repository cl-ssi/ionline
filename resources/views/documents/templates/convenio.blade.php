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

        <div style="clear: both; padding-bottom: 120px"></div>

        <div class="content">
            {!! $document->contentHtml !!}
        </div>

        <div style="clear: both; padding-bottom: 36px"></div>

    </main>
</body>

</html>