<?php

namespace App\Filament\Widgets;

use App\Models\Parameters\News;
use Filament\Widgets\Widget;

class NewsWidget extends Widget
{
    protected static string $view = 'filament.widgets.news-widget';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = '2';

    public function getNews()
    {
        return News::where('until_at', '>=', now())
            ->latest()
            ->take(5)
            ->get();
    }
}
