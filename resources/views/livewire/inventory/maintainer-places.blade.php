<div>
    @section('title', 'Lugares')

    @include('inventory.nav', [
        'establishment' => $establishment
    ])

    @livewire('parameters.places', [
        'establishment' => $establishment
    ])
</div>
