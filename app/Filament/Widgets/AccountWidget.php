<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AccountWidget extends Widget
{
    protected static string $view = 'filament.widgets.account-widget';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = '2';
}
