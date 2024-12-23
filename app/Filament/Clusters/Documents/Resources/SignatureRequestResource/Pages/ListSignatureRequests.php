<?php

namespace App\Filament\Clusters\Documents\Resources\SignatureRequestResource\Pages;

use App\Filament\Clusters\Documents\Resources\SignatureRequestResource;
use App\Models\Documents\SignatureRequest;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Request;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSignatureRequests extends ListRecords
{
    protected static string $resource = SignatureRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs['Pendientes'] = 
            Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',NULL)->where('user_id',auth()->id()));
        $tabs['Completadas'] = 
            Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('status')->where('user_id',auth()->id()));

        if(auth()->user()->can('be god')) {
            $tabs['Todas las solicitudes (god)'] = 
                Tab::make()
                    ->modifyQueryUsing(fn (Builder $query) => $query)
                    ->badge(SignatureRequest::count());
        }

        return $tabs;
    }
}
