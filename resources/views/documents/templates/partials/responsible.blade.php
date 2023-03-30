@if($document->responsible != null)
<div style="padding-bottom: 6px; display: inline-block; vertical-align:top; width: 49%; text-align: right">
    <table class="siete" style="margin-right: 0; margin-left: auto;">
        <tr class="seis">
            <td colspan="3"><strong>RESPONSABLES:</strong></td>
        </tr>
        @foreach($document->responsiblesArray as $responsable)
        <tr>
            <td class="seis">{{ $responsable }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endif