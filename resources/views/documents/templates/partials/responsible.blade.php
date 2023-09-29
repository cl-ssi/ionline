<td>
    @if($document->responsible)
        <strong>RESPONSABLES:</strong>
        @foreach(explode("\n", $document->responsible) as $responsible)
        <li style="margin-left: 10px;">
            {{ str_replace("\r", "", $responsible) }}
        </li>
        @endforeach
    @endif
</td>