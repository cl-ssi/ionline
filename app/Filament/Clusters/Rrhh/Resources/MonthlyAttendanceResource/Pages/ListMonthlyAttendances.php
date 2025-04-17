<?php

namespace App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource;
use App\Models\User;
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

        if (auth()->user()->canAny(abilities: ['be god','Attendance records: admin'])) {
            $tabs['todos'] = Tab::make();
        }

        if (auth()->user()->isManagerOf()->exists()) {
            $userIds = User::whereIn('organizational_unit_id', auth()->user()->isManagerOf->pluck('id'))->pluck('id');
    
            $tabs['Mi Unidad'] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('user_id', $userIds));
        }

        return $tabs;
    }
}
