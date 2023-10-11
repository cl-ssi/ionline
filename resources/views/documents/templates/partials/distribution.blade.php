<td style="width: 60%;">
    @if($document->distribution)
        <strong>DISTRIBUCIÓN:</strong>
        @foreach(explode("\n", $document->distribution) as $distribution)
        <li style="margin-left: 10px;">
            {{ str_replace("\r", "", $distribution) }}
        </li>
        @endforeach
    @endif
</td>