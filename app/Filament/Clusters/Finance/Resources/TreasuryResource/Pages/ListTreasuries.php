<?php

namespace App\Filament\Clusters\Finance\Resources\TreasuryResource\Pages;

use App\Filament\Clusters\Finance\Resources\TreasuryResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTreasuries extends ListRecords
{
    protected static string $resource = TreasuryResource::class;

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
