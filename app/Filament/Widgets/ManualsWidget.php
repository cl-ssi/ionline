<?php

namespace App\Filament\Widgets;

use App\Models\Documents\Manual;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

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
                    ->where('id', '!=', 1)
                    ->orderBy('title', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->action(function (Manual $record) {
                        return redirect()->route('documents.manuals.show', $record->id);
                    })
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
