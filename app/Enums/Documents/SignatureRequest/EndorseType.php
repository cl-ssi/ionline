<?php

namespace App\Enums\Documents\SignatureRequest;

use Filament\Support\Contracts\HasLabel;

enum EndorseType: string implements HasLabel
{
    case Without  = 'without';
    case Optional = 'optional';
    case Chain    = 'chain';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Without  => 'No requiere visación',
            self::Optional => 'Visación opcional',
            self::Chain    => 'Visación en cadena de responsabilidad',
        };
    }
}
