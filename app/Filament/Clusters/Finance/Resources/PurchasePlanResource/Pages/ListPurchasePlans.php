<?php

namespace App\Filament\Clusters\Finance\Resources\PurchasePlanResource\Pages;

use App\Filament\Clusters\Finance\Resources\PurchasePlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Parameters\Parameter;

class ListPurchasePlans extends ListRecords
{
    protected static string $resource = PurchasePlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        if (auth()->user()->can('Purchase Plan: all')) {
            $tabs['Todos'] = Tab::make()
                ->modifyQueryUsing(function (Builder $query): Builder {
                    return $query; // No aplica ningún filtro
            });
        }

        //PLANES DE COMPRAS: OWN INDEX
        $organizationalUnitIn = array();
        $organizationalUnitIn[] = auth()->user()->organizationalUnit->id;

        if(auth()->user()->organizationalUnit->id == Parameter::get('ou', 'ControlEquipos') || auth()->user()->organizationalUnit->id == Parameter::get('ou', 'ControlInfraestructura')){
            $organizationalUnitIn[] = Parameter::get('ou', 'DeptoRRFF');
        }

        if(in_array(auth()->user()->organizationalUnit->id, Parameter::get('ou', ['DeptoAPS','SaludMentalSSI']))){
            $childs_array = auth()->user()->organizationalUnit->childs->pluck('id')->toArray();
            $organizationalUnitIn = [auth()->user()->organizationalUnit->id, ...auth()->user()->organizationalUnit->getAllChilds()];
        }   

        $tabs['Mis Planes de Compras'] = Tab::make()
            ->modifyQueryUsing(function (Builder $query) use ($organizationalUnitIn) : Builder {
                return $query->where('user_creator_id', auth()->id())
                    ->orWhere('user_responsible_id', auth()->id())
                    ->orWhereIn('organizational_unit_id', $organizationalUnitIn);
        });

        return $tabs;
    }
}
