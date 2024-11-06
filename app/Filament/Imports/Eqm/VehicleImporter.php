<?php

namespace App\Filament\Imports\Eqm;

use App\Models\Inventories\Eqm\Vehicle;
use App\Models\ClRegion;
use App\Models\Establishment;
use App\Models\Inventories\Eqm\Brand;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class VehicleImporter extends Importer
{
    protected static ?string $model = Vehicle::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('region')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('establishment')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('body_type')
                ->rules(['max:255']),
            ImportColumn::make('ambulance_type')
                ->rules(['max:255']),
            ImportColumn::make('ambulance_class')
                ->rules(['max:255']),
            ImportColumn::make('samu')
                ->boolean(),
            ImportColumn::make('function')
                ->rules(['max:255']),
            ImportColumn::make('brand')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('model')
                ->rules(['max:255']),
            ImportColumn::make('license_plate')
                ->rules(['max:255']),
            ImportColumn::make('engine_number')
                ->rules(['max:255']),
            ImportColumn::make('mileage')
                ->numeric(),
            ImportColumn::make('ownership_status')
                ->rules(['max:255']),
            ImportColumn::make('conservation_status')
                ->rules(['max:255']),
            ImportColumn::make('acquisition_year')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('useful_life')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('residual_useful_life')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('critical')
                ->boolean(),
            ImportColumn::make('under_warranty')
                ->boolean(),
            ImportColumn::make('warranty_expiry_year')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('under_maintenance_plan')
                ->boolean(),
            ImportColumn::make('year_entered_maintenance_plan')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('internal_or_external_maintenance')
                ->rules(['max:255']),
            ImportColumn::make('provider_or_internal_maintenance')
                ->rules(['max:255']),
            ImportColumn::make('maintenance_agreement_id_or_reference')
                ->rules(['max:255']),
            ImportColumn::make('annual_maintenance_cost')
                ->numeric(),
            ImportColumn::make('annual_maintenance_frequency')
                ->numeric(),
        ];
    }

    public function resolveRecord(): ?Vehicle
    {
        $data = $this->data;

        // Relaciones necesarias
        if (!empty($data['region'])) {
            $region = ClRegion::firstOrCreate(['name' => $data['region']]);
            $data['region_id'] = $region->id;
        }

        if (!empty($data['establishment'])) {
            $establishment = Establishment::firstOrCreate(['name' => $data['establishment']]);
            $data['establishment_id'] = $establishment->id;
        }

        if (!empty($data['brand'])) {
            $brand = Brand::firstOrCreate(['name' => $data['brand']]);
            $data['brand_id'] = $brand->id;
        }

        // Crear o actualizar el registro de vehículo
        return Vehicle::updateOrCreate(
            [
                'license_plate' => $data['license_plate'],
                'engine_number' => $data['engine_number'],
            ],
            $data
        );
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your vehicle import has completed with ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
