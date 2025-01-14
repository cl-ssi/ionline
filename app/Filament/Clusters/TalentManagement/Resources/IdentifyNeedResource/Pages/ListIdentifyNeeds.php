<?php

namespace App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListIdentifyNeeds extends ListRecords
{
    protected static string $resource = IdentifyNeedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        if (auth()->user()->can('DNC: all')) {
            $tabs['Todas'] = Tab::make()
                ->modifyQueryUsing(function (Builder $query): Builder {
                    return $query; // No aplica ningún filtro
            });
        }

        $tabs['Mis Formularios'] = Tab::make()
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->where('user_id', auth()->id());
        });

        return $tabs;
    }
}
