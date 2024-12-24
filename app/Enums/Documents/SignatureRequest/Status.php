<?php

namespace App\Enums\Documents\SignatureRequest;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    case Pending  = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending  => 'Pendiente',
            self::Approved => 'Aprobado',
            self::Rejected => 'Rechazado',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Pending  => 'gray',
            self::Approved => 'success',
            self::Rejected => 'danger',
        };
    }
}
