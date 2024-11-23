<?php

namespace App\Enums\Rrhh;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AuthorityType: string implements HasLabel, HasColor
{
    case Jefetura = 'manager';
    case Delegado = 'delegate';
    case Secretario = 'secretary';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Jefetura => 'Jefetura',
            self::Delegado => 'Delegado/a',
            self::Secretario => 'Secretario/a',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Jefetura => 'success' ,
            self::Delegado => 'gray',
            self::Secretario => 'info', 
        };
    }
}
