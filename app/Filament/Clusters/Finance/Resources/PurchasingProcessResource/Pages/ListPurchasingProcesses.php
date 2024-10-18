<?php

namespace App\Filament\Clusters\Finance\Resources\PurchasingProcessResource\Pages;

use App\Filament\Clusters\Finance\Resources\PurchasingProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPurchasingProcesses extends ListRecords
{
    protected static string $resource = PurchasingProcessResource::class;

    /*
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    */

    public function getTabs(): array
    {
        $tabs['Todas'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => 
                $query
            );

        $tabs[auth()->user()->establishment->name] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => 
                $query->whereRelation('requestForm', 'establishment_id', auth()->user()->establishment_id)
        );

        return $tabs;
    }
}
