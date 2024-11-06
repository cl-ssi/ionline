<?php

namespace App\Filament\Clusters\Inventories\Pages\Eqm;

use App\Filament\Clusters\Inventories;
use Filament\Pages\Page;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TimePicker;

class MaintenanceEntry extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.clusters.inventories.pages.eqm.maintenance-entry';

    protected static ?string $cluster = Inventories::class;

    protected static ?string $navigationGroup = 'Principal';

    protected static ?string $navigationLabel = 'Ingresar mantenimiento';

    protected static ?string $title = 'Ingresar Mantenimiento';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('Inventory'); // Reemplaza con el permiso adecuado
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('maintenance_type')
                ->label('Tipo de Mantenimiento')
                ->options([
                    'equipment' => 'Equipamiento',
                    'vehicle' => 'Vehículo',
                    'infrastructure' => 'Infraestructura',
                ])
                ->required(),

            Select::make('item_id')
                ->label('Seleccionar Ítem')
                ->options([]) // Este campo debería poblarse dinámicamente con ítems relevantes
                ->searchable()
                ->required(),

            DatePicker::make('maintenance_date')
                ->label('Fecha de Mantenimiento')
                ->required(),

            TimePicker::make('maintenance_time')
                ->label('Hora de Mantenimiento'),

            Select::make('maintenance_category')
                ->label('Categoría de Mantenimiento')
                ->options([
                    'motor' => 'Motor',
                    'oil' => 'Aceite',
                    'brakes' => 'Frenos',
                    'electrical' => 'Eléctrico',
                    'other' => 'Otro',
                ])
                ->required(),

            TextInput::make('horometer')
                ->label('Horómetro')
                ->numeric()
                ->required(),

            Textarea::make('description')
                ->label('Descripción del Mantenimiento')
                ->rows(3)
                ->required(),

            TextInput::make('cost')
                ->label('Costo de Mantenimiento')
                ->numeric()
                ->required(),

            TextInput::make('invoice_number')
                ->label('Número de Factura')
                ->maxLength(255),

            TextInput::make('contracting_company')
                ->label('Empresa Mandante')
                ->maxLength(255)
                ->required(),

            TextInput::make('maintenance_provider')
                ->label('Proveedor de Mantenimiento')
                ->maxLength(255)
                ->required(),

            Toggle::make('is_scheduled')
                ->label('¿Es Mantenimiento Programado?')
                ->default(false),

            Toggle::make('requires_follow_up')
                ->label('¿Requiere Seguimiento?')
                ->default(false),

            DatePicker::make('next_maintenance_date')
                ->label('Fecha de Próximo Mantenimiento')
                ->visible(fn ($get) => $get('is_scheduled') === true),
        ];
    }

    public function submit()
    {
        $data = $this->form->getState();
        $this->notify('success', 'Mantención ingresada correctamente.');
    }
}
