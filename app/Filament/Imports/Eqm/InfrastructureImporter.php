<?php

namespace App\Filament\Imports\Eqm;

use App\Models\Inventories\Eqm\Infrastructure;
use App\Models\Parameters\Location;
use App\Models\Parameters\Place;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class InfrastructureImporter extends Importer
{
    protected static ?string $model = Infrastructure::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('location')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('place')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('infrastructure_element_or_specialty')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('intervention_type_description')
                ->rules(['required']),
            ImportColumn::make('quantity')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('condition')
                ->rules(['max:255']),
            ImportColumn::make('norm_accreditation_or_not_applicable')
                ->rules(['max:255']),
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
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?Infrastructure
    {
        $data = $this->data;

        // Crear o recuperar relaciones para Location y Place
        if (!empty($data['location'])) {
            $location = Location::firstOrCreate(['name' => $data['location']]);
            $data['location_id'] = $location->id;
        }

        if (!empty($data['place'])) {
            $place = Place::firstOrCreate(
                ['name' => $data['place']],
                ['location_id' => $location->id]
            );
            $data['place_id'] = $place->id;
        }

        // Crear o actualizar el registro de infraestructura
        return Infrastructure::updateOrCreate(
            [
                'infrastructure_element_or_specialty' => $data['infrastructure_element_or_specialty'],
                'location_id' => $data['location_id'],
                'place_id' => $data['place_id'],
            ],
            $data
        );
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your infrastructure import has completed with ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
