<?php

namespace App\Filament\Clusters\Sgr\Resources\LabelResource\Pages;

use App\Filament\Clusters\Sgr\Resources\LabelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabel extends EditRecord
{
    protected static string $resource = LabelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
