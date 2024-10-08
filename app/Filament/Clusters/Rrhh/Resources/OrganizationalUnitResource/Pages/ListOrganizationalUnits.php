<?php

namespace App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource;
use App\Models\Establishment;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationalUnits extends ListRecords
{
    protected static string $resource = OrganizationalUnitResource::class;

    protected $tabs;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $establishment_ids = explode(',', env('APP_SS_ESTABLISHMENTS'));

        Establishment::whereIn('id',$establishment_ids)->get()->each(function($establishment){
            $this->tabs[$establishment->name] = Tab::make()->query(fn ($query) => $query->where('establishment_id',$establishment->id));
        });

        return $this->tabs;
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return auth()->user()->organizationalUnit->establishment->name;
    }
}
