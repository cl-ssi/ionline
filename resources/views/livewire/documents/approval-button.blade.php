<div>
    <button
        class="btn btn-primary @if(!$button_text) btn-sm @endif"
        wire:click='show({{ $approval }})'
    >
        <i class="fas fa-fw {{ $approval->digital_signature ? 'fas fa-signature' : 'fas fa-certificate' }}"></i>
        <i class="fas fa-fw {{ $approval->approver_ou_id ? 'fa-chess-king' : 'fa-user' }}"></i>
        {{$button_text}}
    </button>

    <!-- Modal -->
    @include('documents.approvals.partials.modal')
</div>
