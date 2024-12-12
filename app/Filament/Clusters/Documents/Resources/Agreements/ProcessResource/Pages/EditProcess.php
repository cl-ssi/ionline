<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Widgets;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcess extends EditRecord
{
    protected static string $resource = ProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\StepsChart::class,
        ];
    }
}
