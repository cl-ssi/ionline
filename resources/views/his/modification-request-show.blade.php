<html lang="es">

@include('documents.templates.partials.head', [
        'title' => "iOnline - Solicitud modificación ficha clínica"
    ])

<body>
    <!-- Define header and footer blocks before your content -->
    @include('documents.templates.partials.header', [
        'establishment' => auth()->user()->organizationalUnit->establishment,
        'linea1' => auth()->user()->organizationalUnit->establishment->name,
        'linea2' => "Departamento de Teconologías de la Información y Comunicaciones",
    ])

    @include('documents.templates.partials.footer', [
        'establishment' => auth()->user()->organizationalUnit->establishment
    ])

    <!-- Define main for content -->
    <main>
        
    <div style="clear: both;padding-top: 170px;"></div>

        <div class="center" style="text-transform: uppercase;">
            <strong style="text-transform: uppercase;">
            SOLICITUD DE MODIFICACIÓN DE FICHA CLÍNICA Nº {{ $modificationRequest->id }}
            </strong>
        </div>


        <div style="clear: both; padding-bottom: 20px"></div>
        
        <br>

        <table class="ocho">
            <tbody>
                <tr>
                    <td width="100"><strong>Fecha registro:</strong></td>
                    <td>{{ $modificationRequest->created_at }}</td>
                </tr>
                <tr>
                    <td width="100"><strong>Solicitante:</strong></td>
                    <td>{{ $modificationRequest->creator->shortName }}</td>
                </tr>
                <tr>
                    <td><strong>Tipo de solicitud:</strong></td>
                    <td>{{ $modificationRequest->type }}</td>
                </tr>
                <tr>
                    <td><strong>Asunto:</td>
                    <td>{{ $modificationRequest->subject }}</strong></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;"><strong>Detalle:</td>
                    <td>{{ $modificationRequest->body }}</strong></td>
                </tr>
            </tbody>
        </table>


        <div style="clear: both;padding-top: 156px;"></div>

        <!-- Sección de las aprobaciones -->
        <div class="signature-container">
            @foreach($modificationRequest->approvals as $approval)

                <div class="signature">
                    @include('sign.approvation', [
                        'approval' => $approval
                    ])
                </div>

            @endforeach
        </div>


    </main>

</body>

</html>
