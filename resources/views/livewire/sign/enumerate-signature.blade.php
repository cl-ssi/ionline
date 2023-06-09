<div>
    <button
        class="btn btn-primary btn-sm"
        wire:click="enumerate"
        wire:loading.attr="disabled"
        wire:target='enumerate'
    >
        <span
            wire:loading.remove
            wire:target="enumerate"
        >
            <i class="fas fa-list-ol"></i>
        </span>

        <span
            class="spinner-border spinner-border-sm"
            role="status"
            wire:loading
            wire:target="enumerate"
            aria-hidden="true"
        >
        </span>
        Enumerar
    </button>
</div>
