<?php

namespace App\Enums\Documents\Agreements;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasLabel, HasColor
{
    case Draft = 'draft';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Finished = 'finished';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft    => 'Borrador',
            self::Approved => 'Aprobado',
            self::Rejected => 'Rechazado',
            self::Finished => 'Finalizado',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Draft    => 'secondary',
            self::Approved => 'success',
            self::Rejected => 'danger',
            self::Finished => 'primary',
        };
    }
}
