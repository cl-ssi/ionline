<?php

namespace App\Filament\Clusters\Inventories\Pages\Eqm;

use App\Filament\Clusters\Inventories;
use Filament\Pages\Page;

use App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets\MedicalEquipmentChart;
use App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets\IndustrialEquipmentChart;
use App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets\EquipmentOverview;
use App\Filament\Clusters\Inventories\Resources\InfrastructureResource\Widgets\InfrastructureOverview;
use App\Filament\Clusters\Inventories\Resources\VehicleResource\Widgets\VehicleOverview;

class MaintenanceDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.clusters.inventories.pages.eqm.maintenance-dashboard';

    protected static ?string $cluster = Inventories::class;

    protected static ?string $navigationGroup = 'Dashboards';

    protected static ?string $navigationLabel = 'Dasboard de mantenimiento';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('Inventory'); // Reemplaza con el permiso adecuado
    }

    public function getHeaderWidgets(): array
    {
        return [
            EquipmentOverview::class,
            MedicalEquipmentChart::class,
            IndustrialEquipmentChart::class,
            InfrastructureOverview::class,
            VehicleOverview::class,
        ];
    }
}
