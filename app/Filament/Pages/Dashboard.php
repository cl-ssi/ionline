<?php

namespace App\Filament\Pages;

use App\Filament\Widgets;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;

class Dashboard extends BaseDashboard
{
    protected static $columns = 3;

    protected static ?string $title = 'Escritorio';

    public function getWidgets(): array
    {
        return Filament::getWidgets();
    }

    /**
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int | string | array
    {
        return 3;
    }
}
