<div>
    {{-- In work, do what you enjoy. --}}
    @include('inventory.nav', [
        'establishment' => auth()->user()->organizationalUnit->establishment->id
    ])
    <h3>Actualización Masiva Emplazamiento</h3>
</div>
