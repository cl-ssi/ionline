<?php

namespace App\Filament\Imports\Eqm;

use App\Models\Inventories\Eqm\Equipment;
use App\Models\Parameters\Location; // Modelo para 'location'
use App\Models\Parameters\Place; // Modelo para 'place'
use App\Models\Inventories\Eqm\Category; // Modelo para 'category'
use App\Models\Inventories\Eqm\Subcategory; // Modelo para 'subcategory'
use App\Models\Inventories\Eqm\Brand; // Modelo para 'brand'
use App\Models\Inventories\Eqm\Supplier; // Modelo para 'supplier'
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class IndustrialEquipmentImporter extends Importer
{
    protected static ?string $model = Equipment::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('location')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('place')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('category')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('subcategory')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('brand')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('model')
                ->rules(['max:255']),
            ImportColumn::make('serial_number')
                ->rules(['max:255']),
            ImportColumn::make('inventory_number')
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
            ImportColumn::make('property')
                ->rules(['max:255']),
            ImportColumn::make('condition')
                ->rules(['max:255']),
            ImportColumn::make('compilance')
                ->rules(['max:255']),
            ImportColumn::make('assurance')
                ->rules(['max:255']),
            ImportColumn::make('warranty_expiry_year')
                ->rules(['max:255']),  
            ImportColumn::make('under_maintenance_plan')
                ->rules(['max:255']),    
            ImportColumn::make('year_entered_maintenance_plan')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('type_of_maintenance')
                ->rules(['max:255']),
            ImportColumn::make('supplier')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('maintenance_reference')
                ->rules(['max:255']),
            ImportColumn::make('annual_cost')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('annual_maintenance_frequency')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?Equipment
    {
        $data = $this->data;

        $data['type'] = "Industrial";

        // Ensure relationships are created if they do not exist
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

        if (!empty($data['category'])) {
            $category = Category::firstOrCreate(['name' => $data['category']]);
            $data['category_id'] = $category->id;
        }

        if (!empty($data['subcategory'])) {
            $subcategory = Subcategory::firstOrCreate(['name' => $data['subcategory']]);
            $data['subcategory_id'] = $subcategory->id;
        }

        if (!empty($data['brand'])) {
            $brand = Brand::firstOrCreate(['name' => $data['brand']]);
            $data['brand_id'] = $brand->id;
        }

        if (!empty($data['supplier'])) {
            $supplier = Supplier::firstOrCreate(['name' => $data['supplier']]);
            $data['supplier_id'] = $supplier->id;
        }

        // Create or update the Equipment record
        return Equipment::updateOrCreate(
            ['name' => $data['name'],
            'brand_id' => $data['brand_id'],
            'model' => $data['model'],
            'serial_number' => $data['serial_number']], // Criteria for updating existing records
            $data
        );

        // return new Equipment();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your industrial equipment import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    protected function beforeSave(): void
    {
        // Additional logic before saving can be added here
    }
}
