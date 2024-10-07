<?php

namespace App\Filament\Clusters\Parameters\Resources\PhraseOfTheDayResource\Pages;

use App\Filament\Clusters\Parameters\Resources\PhraseOfTheDayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhraseOfTheDays extends ListRecords
{
    protected static string $resource = PhraseOfTheDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
