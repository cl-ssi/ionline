<html lang="es">

@include('documents.templates.partials.head', [
    'title' => "Justificación de marca de asistencia"
])

<body>
    <!-- Define header and footer blocks before your content -->
    @include('documents.templates.partials.header', [
        'establishment' => $noAttendanceRecord->user->organizationalUnit->establishment,
        'linea1' => $noAttendanceRecord->user->organizationalUnit->establishment->name,
        'linea2' => $noAttendanceRecord->user->organizationalUnit->name,
    ])

    @include('documents.templates.partials.footer', [
        'establishment' => auth()->user()->organizationalUnit->establishment
    ])

    <!-- Define main for content -->
    <main>
        
    <div style="clear: both;padding-top: 170px;"></div>

        <div class="center" style="text-transform: uppercase;">
            <strong style="text-transform: uppercase;">
            JUSTIFICACIÓN DE REGISTRO DE ASISTENCIA Nº {{ $noAttendanceRecord->id }}
            </strong>
        </div>

        
        <div style="clear: both; padding-bottom: 20px"></div>
        
        <br>

        <table class="ocho">
            <tbody>
                <tr>
                    <td width="120"><strong>Solicitante:</strong></td>
                    <td>{{ $noAttendanceRecord->user->fullName }}</td>
                </tr>
                <tr>
                    <td width="120"><strong>Unidad Organizacional:</strong></td>
                    <td>{{ $noAttendanceRecord->user->organizationalUnit->name }}</td>
                </tr>
                <tr>
                    <td width="120"><strong>Fecha y hora del registro:</strong></td>
                    <td>{{ $noAttendanceRecord->date }}</td>
                </tr>
                <tr>
                    <td width="120" style="vertical-align: top;"><strong>Fundamento:</strong></td>
                    <td>
                        {{ $noAttendanceRecord->reason->name }} <br>
                        {{ $noAttendanceRecord->observation }}
                    </td>
                </tr>

            </tbody>
        </table>


        <div style="clear: both;padding-top: 156px;"></div>

        <!-- Sección de las aprobaciones -->
        <div class="signature-container">
            @if($noAttendanceRecord->approval)

                <div class="signature">
                    @include('sign.approvation', [
                        'approval' => $noAttendanceRecord->approval
                    ])
                </div>

            @endif
        </div>


    </main>

</body>

</html>
