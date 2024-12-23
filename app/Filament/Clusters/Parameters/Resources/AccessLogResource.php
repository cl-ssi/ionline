<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\AccessLogResource\Pages;
use App\Filament\Clusters\Parameters\Resources\AccessLogResource\RelationManagers;
use App\Filament\Clusters\Rrhh\Resources\UserResource\Pages\EditUser;
use App\Models\Parameters\AccessLog;
use App\Models\User;
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

    protected static ?string $navigationGroup = 'Sistema';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make(name: 'user.tinyName')
                    ->numeric()
                    ->label('Usuario')
                    ->icon(fn($record) => !$record->user->active ? 'heroicon-o-no-symbol' : '')
                    ->iconPosition(IconPosition::After)
                    ->searchable(['full_name']),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('switchUser.tinyName')
                    ->label('Usuario Switch')
                    ->numeric()
                    ->searchable(['full_name']),
                Tables\Columns\TextColumn::make('enviroment')
                    ->colors([
                        'success' => 'Cloud Run',
                        'primary' => 'Servidor',
                        'danger' => 'local',
                        'dark' => 'default'
                    ])
                    ->label('Ambiente')
                    ->searchable(),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->options(fn(): array => User::pluck('full_name', 'id')->toArray())
                    ->label('Usuario')
                    ->relationship('user', 'name',)
                    ->searchable(),
                Tables\Filters\SelectFilter::make('switchUser')
                    ->options(fn(): array => User::pluck('full_name', 'id')->toArray())
                    ->label('Swicher')
                    ->relationship('switchUser', 'name',)
                    ->searchable(),
                Tables\Filters\Filter::make('local')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'local'))
                    ->label('Local'),
                Tables\Filters\Filter::make('switch')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'switch'))
                    ->label('Switch'),
                Tables\Filters\Filter::make('clave_unica')
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
