<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs d-print-none" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{$currentTab == 'charges_tab' ? 'active' : ''}}" data-toggle="tab" role="tab" wire:click.prevent="changeTab('charges_tab')">Mis cargas AmiPASS</a>
            <!-- <button class="nav-link active" id="cargas-tab" data-bs-toggle="tab" data-bs-target="#cargas" type="button" role="tab" aria-controls="cargas" aria-selected="true">Mis cargas</button> -->
        </li>
        <li class="nav-item">
            <a class="nav-link {{$currentTab == 'absences_tab' ? 'active' : ''}}" data-toggle="tab" role="tab" wire:click.prevent="changeTab('absences_tab')">Mis ausentismos</a>
            <!-- <button class="nav-link" id="ausentismos-tab" data-bs-toggle="tab" data-bs-target="#ausentismos" type="button" role="tab" aria-controls="ausentismos" aria-selected="true">Mis ausentismos</button> -->
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('welfare.amipass.new-beneficiary-request')}}">Solicitar beneficio</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content mt-3">
        <div wire:key="cargas">
            @if($currentTab == 'charges_tab')
            <div class="tab-pane" id="mis-cargas">
                @livewire('welfare.amipass.charge-index')
            </div>
            @endif
        </div>
        <div wire:key="ausentismos">
            @if($currentTab == 'absences_tab')
            <div class="tab-pane" id="mis-ausentismos">
                @livewire('welfare.amipass.absences-index')
            </div>
            @endif
        </div>
    </div>
</div>