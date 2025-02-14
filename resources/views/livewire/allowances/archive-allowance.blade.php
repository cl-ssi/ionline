<div>
    <div class="list-group mt-3">
        <button wire:click="toggleArchive" class="btn {{ $isArchived ? 'btn-secondary' : 'btn-success' }} btn-sm">
            <i class="fas {{ $isArchived ? 'fa-box-open' : 'fa-archive' }}"></i>
            {{ $isArchived ? 'Desarchivar' : 'Archivar' }} Viático
        </button>
    </div>
</div>