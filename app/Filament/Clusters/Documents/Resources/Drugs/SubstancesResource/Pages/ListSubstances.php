<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Drugs\Protocol;

class ListSubstances extends ListRecords
{
    protected static string $resource = SubstancesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('report_confiscated')
                ->label('Informe ISP')
                ->icon('heroicon-o-chart-bar')
                ->url(route('filament.intranet.documents.resources.drugs.substances.report-confiscated')),
            
            Actions\Action::make('all_result')
                ->label('Vincular Resultados')
                ->icon('heroicon-o-link')
                ->action(function () {
                    $protocols = Protocol::whereNull('result_substance_id')->get();
                    foreach($protocols as $protocol){
                        if($protocol->result == 'Positivo'){
                            $protocol->receptionItem->result_substance_id = $protocol->receptionItem->substance->result_id;
                            $protocol->receptionItem->save();
                        }
                    }
                })
        ];
    }
}
