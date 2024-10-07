<?php

namespace App\Filament\Clusters\Parameters\Resources\PhraseOfTheDayResource\Pages;

use App\Filament\Clusters\Parameters\Resources\PhraseOfTheDayResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePhraseOfTheDay extends CreateRecord
{
    protected static string $resource = PhraseOfTheDayResource::class;
}
