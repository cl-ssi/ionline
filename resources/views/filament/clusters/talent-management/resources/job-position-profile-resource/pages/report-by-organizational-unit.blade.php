<x-filament-panels::page>
    <x-filament::tabs>
        <x-filament::tabs.item :active="$activeTab === 'general'" wire:click="$set('activeTab', 'general')">
            Reporte General
        </x-filament::tabs.item>

        <x-filament::tabs.item :active="$activeTab === 'subdir_gestion_asistencial'" wire:click="$set('activeTab', 'subdir_gestion_asistencial')">
            Subdirección de Gestión Asistencial
        </x-filament::tabs.item>

        <x-filament::tabs.item :active="$activeTab === 'subdir_desarrollo_personas'" wire:click="$set('activeTab', 'subdir_desarrollo_personas')">
            Subdirección de Gestión y Desarrollo de las Personas
        </x-filament::tabs.item>

        <x-filament::tabs.item :active="$activeTab === 'subdir_recursos_fisicos'" wire:click="$set('activeTab', 'subdir_recursos_fisicos')">
            Subdirección de Recursos Físicos y Financieros
        </x-filament::tabs.item>
    </x-filament::tabs>

    <div>
        {{ $this->table }}
    </div>
</x-filament-panels::page>
