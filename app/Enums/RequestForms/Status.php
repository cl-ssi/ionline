<?php

namespace App\Enums\RequestForms;

// use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
// use Filament\Support\Contracts\HasIcon;

enum Status: string implements HasLabel
{
    case Pending    = 'pending';
    case Rejected   = 'rejected';
    case Approved   = 'approved';
    case Closed     = 'closed';
    case Saved      = 'saved';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending   => 'Pendiente',
            self::Rejected  => 'Rechazado',
            self::Approved  => 'Aprobado',
            self::Closed    => 'Cerrado',
            self::Saved     => 'Guardado',
        };
    }
}