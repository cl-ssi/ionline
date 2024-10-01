<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\RelationManagers\BaseAuditsRelationManager;

class AuditsRelationManager extends BaseAuditsRelationManager
{
    protected static string $relationship = 'audits';
}
