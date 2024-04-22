@if($document->distribution OR $document->responsible)
    @if($document->type->name == 'Oficio' OR $document->type->name == 'Resolución')
        <table class="seis distribution-responsible" style="margin-left: -3px; width: 100%; padding-top: 160px;">
    @else
        <table class="seis" style="margin-left: -3px; width: 100%">
    @endif
        <tr style="vertical-align: top;">
            @include('documents.templates.partials.distribution')
            @include('documents.templates.partials.responsible')
        </tr>
    </table>
@endif