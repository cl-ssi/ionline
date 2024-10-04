<?php

namespace App\Filament\Clusters\Rrhh\Resources\Rrhh\AttendanceRecordResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\Rrhh\AttendanceRecordResource;
use App\Filament\Exports\Rrhh\AttendanceRecordExporter;
use Filament\Actions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAttendanceRecords extends ListRecords
{
    protected static string $resource = AttendanceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->label('Exportar registros')
                ->exporter(AttendanceRecordExporter::class)
                ->formats([
                    ExportFormat::Xlsx,
                ])
                ->visible(fn () => auth()->user()->canAny(['be god', 'Attendance records: admin']))
                ->columnMapping(false),
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
