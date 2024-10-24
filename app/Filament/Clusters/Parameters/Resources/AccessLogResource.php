<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\AccessLogResource\Pages;
use App\Filament\Clusters\Parameters\Resources\AccessLogResource\RelationManagers;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\Parameters\AccessLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Facades\FilamentColor;
use Filament\Tables\Filters\Filter;

class AccessLogResource extends Resource
{
    protected static ?string $model = AccessLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $modelLabel = 'Ultimos Accesos';

    protected static ?string $cluster = Parameters::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('enviroment')
                    ->colors([
                        'success' => 'Cloud Run',
                        'primary' => 'Servidor',
                        'danger' => 'local',
                        'dark' => 'default'
                    ])
                    ->label('Ambiente')
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'user.tinnyName')
                    ->numeric()
                    ->label('Usuario')
                    ->icon(fn($record) => !$record->user->active ? 'heroicon-o-no-symbol' : '')
                    ->iconPosition(IconPosition::After)
                    ->searchable(['name', 'fathers_family'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('switchUser.tinnyName')
                    ->label('Usuario Switch')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('created_at')
            ->filters([
                Filter::make('local')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'local'))
                    ->label('Local'),

                Filter::make('switch')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'switch'))
                    ->label('Switch'),

                Filter::make('clave_unica')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'Clave Unica'))
                    ->label('Clave Unica'),
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccessLogs::route('/'),
            'create' => Pages\CreateAccessLog::route('/create'),
        ];
    }
}
