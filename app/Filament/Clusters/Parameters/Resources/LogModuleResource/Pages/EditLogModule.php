<?php

namespace App\Filament\Clusters\Parameters\Resources\LogModuleResource\Pages;

use App\Filament\Clusters\Parameters\Resources\LogModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogModule extends EditRecord
{
    protected static string $resource = LogModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
