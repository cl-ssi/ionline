<?php

namespace App\Filament\Clusters\Finance\Resources\DteResource\Pages;

use App\Filament\Clusters\Finance\Resources\DteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDtes extends ListRecords
{
    protected static string $resource = DteResource::class;

    public function getTabs(): array
    {
        $tabs['dtes'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => 
                $query->where(column: 'establishment_id', operator: auth()->user()->establishment_id)
                ->whereNull('rejected')
            );
        $tabs['revisión'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => 
                $query->whereNotIn('tipo_documento', ['guias_despacho','nota_debito','nota_credito'])
                    ->whereNull('rejected')
                    ->where('all_receptions', 1)
                    ->where('establishment_id', auth()->user()->organizationalUnit->establishment->id)
                    ->where(function (Builder $query) {
                        $query->whereNull('payment_ready')
                            ->orWhere('payment_ready', 0);
                    })
            );
        $tabs['rechazadas'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => 
                $query->whereNotNull('rejected')
                    ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            );
        $tabs['pendiente TGR'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => 
                $query->whereNull('rejected')
                    ->where('all_receptions', 1)
                    ->where('payment_ready', 1)
                    ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
                );
        $tabs['pagos institucionales'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => 
                $query->whereNull('rejected')
                    ->where('tipo_documento', 'LIKE', 'factura_%')
                    ->where('all_receptions', 1)
                    ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
                    ->where('payment_ready', 1)
                    ->where('paid_manual', 1)
                );
        $tabs['pagos TGR'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => 
                $query->whereNull('rejected')
                    ->where('tipo_documento', 'LIKE', 'factura_%')
                    ->where('all_receptions', 1)
                    ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
                    ->where('payment_ready', 1)
                );

        if (auth()->user()->can('be god')) {
            $tabs['todas (be god)'] = Tab::make();
        }

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
