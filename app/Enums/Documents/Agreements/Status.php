<?php

namespace App\Enums\Documents\Agreements;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    case Draft    = 'draft';
    case Endorsed = 'endorsed';
    case Signed   = 'signed';
    case Finished = 'finished';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft    => 'Borrador',
            self::Endorsed => 'Visado',
            self::Signed   => 'Firmado',
            self::Finished => 'Finalizado',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Draft    => 'gray',
            self::Endorsed => 'primary',
            self::Signed   => 'primary',
            self::Finished => 'success',
        };
    }
}
