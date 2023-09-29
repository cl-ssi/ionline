@if($document->distribution OR $document->responsible)
    <table class="seis" style="margin-left: -3px; padding-top: 160px; width: 100%">
        <tr style="vertical-align: top;">
            @include('documents.templates.partials.distribution')
            @include('documents.templates.partials.responsible')
        </tr>
    </table>
@endif