<?php

namespace App\Filament\Clusters\Rrhh\Resources\Rrhh;

use App\Filament\Clusters\Rrhh;
use App\Filament\Clusters\Rrhh\Resources\Rrhh\AttendanceRecordResource\Pages;
use App\Filament\Clusters\Rrhh\Resources\Rrhh\AttendanceRecordResource\RelationManagers;
use App\Models\Rrhh\AttendanceRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceRecordResource extends Resource
{
    protected static ?string $model = AttendanceRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $cluster = Rrhh::class;

    protected static ?string $modelLabel = 'registro de asistencia';

    protected static ?string $pluralModelLabel = 'registros de asistencia';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('record_at')
                    ->label('Fecha y hora')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options([
                        1 => 'Entrada',
                        0 => 'Salida',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('observation')
                    ->label('Observación')
                    ->maxLength(255)
                    ->default(null)
                    ->columnSpan(2),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.shortName')
                    ->label('Usuario')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('record_at')
                    ->label('Fecha y hora')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('type')
                    ->label('Tipo')
                    ->trueIcon('bi-door-open')
                    ->falseIcon('bi-door-closed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('observation')
                    ->label('Observación')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('establishment.name')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListAttendanceRecords::route('/'),
            'create' => Pages\CreateAttendanceRecord::route('/create'),
            'edit' => Pages\EditAttendanceRecord::route('/{record}/edit'),
        ];
    }
}
