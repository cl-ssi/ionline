<?php

namespace App\Filament\Clusters\Finance\Resources\ReceptionResource\Pages;

use App\Filament\Clusters\Finance\Resources\ReceptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;

class ListReceptions extends ListRecords
{
    protected static string $resource = ReceptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'mias' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('creator_id', auth()->id())),
            auth()->user()->organizationalUnit->name => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('creator_ou_id', auth()->user()->organizational_unit_id)),
            auth()->user()->establishment->name => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)),
        ];
    }
}
