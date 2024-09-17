<?php

namespace App\Filament\Clusters\Documents\Resources\DocumentResource\Pages;

use App\Filament\Clusters\Documents\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs['Mis documentos'] = 
            Tab::make()->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id()));
        $tabs['Documentos de mi unidad'] = 
            Tab::make()->modifyQueryUsing(fn (Builder $query) => $query->where('organizational_unit_id', auth()->user()->organizational_unit_id));
        
        if(auth()->user()->can('be god')) {
            $tabs['Todos los documentos (god)'] = 
                Tab::make()->modifyQueryUsing(fn (Builder $query) => $query);
        }

        return $tabs;
    }
}
