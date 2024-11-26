<?php

namespace App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMonthlyAttendances extends ListRecords
{
    protected static string $resource = MonthlyAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs['mis registros'] = Tab::make()
            ->modifyQueryUsing(callback: fn (Builder $query): Builder => $query->where(column: 'user_id', operator: auth()->id()));

        if (auth()->user()->canAny(abilities: ['be god','Attendance records: admin'])) {
            $tabs[auth()->user()->establishment->name] = Tab::make()
                ->modifyQueryUsing(callback: fn (Builder $query): Builder => $query->where('establishment_id', auth()->user()->establishment_id));
        }

        if (auth()->user()->can(abilities: 'be god')) {
            $tabs['todos'] = Tab::make();
        }
        return $tabs;
    }
}
