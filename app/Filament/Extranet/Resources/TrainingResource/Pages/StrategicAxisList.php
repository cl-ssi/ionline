<?php

namespace App\Filament\Extranet\Resources\TrainingResource\Pages;

use App\Filament\Extranet\Resources\TrainingResource;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use App\Models\Trainings\StrategicAxis;
use Illuminate\Database\Eloquent\Builder;

class StrategicAxisList extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    
    protected static string $resource = TrainingResource::class;

    protected static string $view = 'filament.extranet.pages.strategic-axis-list';

    protected static ?string $title = 'Guía Ejes Estratégicos (EE)';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(function (Builder $query) {
                return StrategicAxis::query();
            })
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('impactObjectives.description')
                    ->label('Nombre')
                    ->bulleted(),

                    // impactObjectives
            ])
            ->filters([
                //
            ])
            ->actions([
                // Define aquí tus acciones
            ])
            ->bulkActions([
                // Define aquí tus acciones en bloque
            ]);
    }
}
