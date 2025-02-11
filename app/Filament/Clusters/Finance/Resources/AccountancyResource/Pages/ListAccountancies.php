<?php

namespace App\Filament\Clusters\Finance\Resources\AccountancyResource\Pages;

use App\Filament\Clusters\Finance\Resources\AccountancyResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAccountancies extends ListRecords
{
    protected static string $resource = AccountancyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Todos' => Tab::make(),
            'Estado de Pago' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('treasureable_type', '=', 'App\\Models\\Finance\\Dte')),
            'Pago Funcionario' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('treasureable_type', '=', 'App\\Models\\Finance\\AdministrativeExpense')),
            'Viaticos' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('treasureable_type', '=', 'App\\Models\\Allowances\\Allowance')),
        ];
    }
}
