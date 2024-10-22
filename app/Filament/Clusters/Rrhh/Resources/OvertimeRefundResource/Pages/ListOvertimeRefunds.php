<?php

namespace App\Filament\Clusters\Rrhh\Resources\OvertimeRefundResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\OvertimeRefundResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOvertimeRefunds extends ListRecords
{
    protected static string $resource = OvertimeRefundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs['mías'] = Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id()));
        
        if(auth()->user()->can('Users: overtime refund admin')) {
            $tabs[auth()->user()->establishment->name] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('establishment_id', auth()->user()->establishment_id));
        }

        if(auth()->user()->can('be god')) {
            $tabs['Todas (god)'] = 
                Tab::make();
        }

        return $tabs;
    }
}
