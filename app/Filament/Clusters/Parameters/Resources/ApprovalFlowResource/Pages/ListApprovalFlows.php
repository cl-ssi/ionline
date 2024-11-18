<?php

namespace App\Filament\Clusters\Parameters\Resources\ApprovalFlowResource\Pages;

use App\Filament\Clusters\Parameters\Resources\ApprovalFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovalFlows extends ListRecords
{
    protected static string $resource = ApprovalFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
