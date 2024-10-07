<?php

namespace App\Filament\Clusters\Parameters\Resources\PhraseOfTheDayResource\Pages;

use App\Filament\Clusters\Parameters\Resources\PhraseOfTheDayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhraseOfTheDay extends EditRecord
{
    protected static string $resource = PhraseOfTheDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
