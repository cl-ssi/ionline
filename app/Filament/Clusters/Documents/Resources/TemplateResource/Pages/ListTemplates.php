<?php

namespace App\Filament\Clusters\Documents\Resources\TemplateResource\Pages;

use App\Filament\Clusters\Documents\Resources\TemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemplates extends ListRecords
{
    protected static string $resource = TemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
