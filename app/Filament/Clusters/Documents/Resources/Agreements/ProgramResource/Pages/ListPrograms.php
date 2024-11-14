<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource;
use App\Models\Parameters\Program;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPrograms extends ListRecords
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        // Obtener todos los períodos distintos
        $periods = Program::select('period')
            ->distinct()
            ->where('period', '>', now()->year - 5)
            ->orderBy('period','desc')
            ->pluck('period');

        foreach ($periods as $period) {
            $tabs[$period] = Tab::make()
                ->label($period)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('period', $period));
        }

        // Crear las pestañas dinámicamente
        $tabs['todos'] = Tab::make();

        return $tabs;
    }
}
