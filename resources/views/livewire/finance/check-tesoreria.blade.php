<div>
    <button class="btn btn-sm {{ $dte->check_tesoreria ? 'btn-success' : 'btn-outline-success' }}" wire:click="checkTesoreria()">
        <i class="bi bi-check"></i>
    </button>
</div>