<div>    
    @if($rem_file and $rem_file->name)
    link    
    <button type="button" wire:click="lock_unlock" class="btn btn-sm btn-outline-primary">
        <i class="fas {{$rem_file->is_locked ? 'fa-lock' : 'fa-lock-open' }}"></i>
    </button><br>
    @endif

    @if(!$rem_file or $rem_file->locked)
    <button type="button" wire:click="save()" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-save"></i>
    </button><br>
    @endif

    

</div>