@if($document->distributionHtml != null)
<div class="firma seis" style="padding-top: 6px; padding-bottom: 8px; display: inline-block; vertical-align:top; width: 49%;">
    <div style="padding-bottom: 4px;"><strong>DISTRIBUCIÓN:</strong></div>
    <div style="padding-bottom: 4px;">{!! $document->distributionHtml !!}</div>
</div>
@endif