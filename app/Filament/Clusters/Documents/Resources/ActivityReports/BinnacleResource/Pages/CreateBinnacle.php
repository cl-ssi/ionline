<?php

namespace App\Filament\Clusters\Documents\Resources\ActivityReports\BinnacleResource\Pages;

use App\Filament\Clusters\Documents\Resources\ActivityReports\BinnacleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBinnacle extends CreateRecord
{
    protected static string $resource = BinnacleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
    
        return $data;
    }
}
