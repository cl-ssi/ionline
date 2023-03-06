<div>
    Código interno: {{ $meeting->id }}

    <div class="titulo">Acta de reunión Ley de Lobby {{ $meeting->subject }}</div>
    <br>

    <table class="table ocho">
        <tr>
            <td><strong>Solicitante</strong></td>
            <td>{{ $meeting->petitioner }}</td>
        </tr>
        <tr>
            <td><strong>Fecha</strong></td>
            <td>{{ $meeting->date }}</td>
        </tr>
        <tr>
            <td><strong>Mecanismo</strong></td>
            <td>{{ $meeting->mecanism }}</td>
        </tr>
        <tr>
            <td><strong>Hora Inicio/Término</strong></td>
            <td>{{ $meeting->start_at }} - {{ $meeting->end_at }}</td>
        </tr>
    </table>
    <br>

    <table class="table ocho">
        <tr>
            <td>
                <strong>Tema</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $meeting->subject }}</td>
        </tr>
    </table>
    <br>

    <table class="table ocho">
        <tr>
            <td>
                <strong>Expositores</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $meeting->exponents }}</td>
        </tr>
    </table>
    <br>

    
    <table class="table ocho">
        <tr>
            <td>
                <strong>Participantes</strong>
            </td>
        </tr>
        <tr>
            <td>
                @foreach($meeting->participants as $participant)  
                <li>{{ $participant->shortName }} - {{ $participant->position }} - {{ $participant->organizationalUnit->name }} - {{ $participant->organizationalUnit->establishment->alias }}</li>
                @endforeach
            </td>
        </tr>
    </table>
    <br>

    <table class="table ocho">
        <tr>
            <td>
                <strong>Detalle</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $meeting->details }}</td>
        </tr>
    </table>
    <br>

    <table class="table ocho">
        <tr>
            <td>
                <strong>Acuerdos</strong>
            </td>
        </tr>
        <tr>
            <td>
                @foreach($meeting->compromises as $compromise)  
                <li>{{ $compromise->date }} - {{ $compromise->name }} - {{ $compromise->status }}</li>
                @endforeach
            </td>
        </tr>
    </table>
</div>
