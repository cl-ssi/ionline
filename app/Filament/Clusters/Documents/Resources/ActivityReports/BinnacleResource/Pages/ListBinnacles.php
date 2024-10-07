<?php

namespace App\Filament\Clusters\Documents\Resources\ActivityReports\BinnacleResource\Pages;

use App\Filament\Clusters\Documents\Resources\ActivityReports\BinnacleResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBinnacles extends ListRecords
{
    protected static string $resource = BinnacleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'mis bitacoras' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id())),
            'todas' => Tab::make(),
        ];
    }
}
