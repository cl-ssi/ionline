<x-filament-panels::page>
    <h2 class="text-2xl font-bold mb-4">Reporte ISP - Items por Sustancia</h2>

    <div class="mb-6">
        {{ $this->form }}

        <div class="mt-6 flex justify-end">
            <x-filament::button wire:click="applyFilters">
                Aplicar Filtros
            </x-filament::button>
        </div>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
