<div>
    <input type="checkbox" wire:click="toggleCenabast" wire:model="isCenabast">
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
</div>
