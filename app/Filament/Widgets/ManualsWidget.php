<?php

namespace App\Filament\Widgets;

use App\Models\Documents\Manual;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Storage;

class ManualsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getTableHeading(): string
    {
        return 'Manuales';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Manual::query()
                    ->whereNotNull('file')
                    ->orderBy('title', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 1, '.', '')),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->url(fn (Manual $record): string => Storage::url($record->file))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
