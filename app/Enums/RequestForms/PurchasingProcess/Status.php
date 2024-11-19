<?php

namespace App\Enums\RequestForms\PurchasingProcess;

// use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
// use Filament\Support\Contracts\HasIcon;

enum Status: string implements HasLabel
{
    case In_process = 'in_process';
    case Purchased  = 'purchased';
    case Finalized  = 'finalized';
    case Canceled   = 'canceled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::In_process    => 'En proceso',
            self::Purchased     => 'Comprado',
            self::Finalized     => 'Finalizado',
            self::Canceled      => 'Anulado',
        };
    }
}