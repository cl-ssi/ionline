<?php

namespace App\Filament\Clusters\Rrhh\Resources;

use App\Filament\Clusters\Rrhh;
use App\Filament\Clusters\Rrhh\Resources\AttendanceRecordResource\Pages;
use App\Models\Rrhh\AttendanceRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class AttendanceRecordResource extends Resource
{
    protected static ?string $model = AttendanceRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $cluster = Rrhh::class;

    protected static ?string $modelLabel = 'registro de asistencia';

    protected static ?string $pluralModelLabel = 'registros de asistencia';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Asistencia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(4)
                    ->schema([
                        // Este campo no se almacena, solo informativo, en el AttendanceRecordObserver se asigna el valor
                        Forms\Components\DateTimePicker::make('current_time')
                            ->label('Fecha y hora')
                            ->default(now())
                            ->disabled(),
                        Forms\Components\Select::make('verification')
                            ->label('Medio de verificación')
                            ->options([
                                'iOnline'  => 'iOnline',
                                'Finger'   => 'Huella',
                                'Password' => 'Contraseña',
                            ])
                            ->default('iOnline')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                    ]),
                Forms\Components\Grid::make(4)
                    ->schema([
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
                            ->columnSpan(3),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.shortName')
                    ->label('Usuario')
                    ->sortable(['full_name'])
                    ->searchable(['full_name']),
                Tables\Columns\TextColumn::make('record_at')
                    ->label('Fecha y hora')
                    ->dateTime('Y-m-d H:i')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\IconColumn::make('type')
                    ->label('Tipo')
                    ->trueIcon('bi-door-open')
                    ->falseIcon('bi-door-closed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('observation')
                    ->label('Observación')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('verification')
                    ->label('Medio')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sirh_at')
                    ->date('Y-m-d H:i')
                    ->sortable()
                    ->description(description: fn (AttendanceRecord $record): string => $record->rrhhUser->shortName ?? '')
                    ->visible(condition: fn (): bool => auth()->user()->canAny(['be god', 'Attendance records: admin'])),
                Tables\Columns\TextColumn::make('establishment.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('sirh_at')
                    ->label('Sirh OK')
                    ->nullable()
                    ->visible(fn () => auth()->user()->canAny(['be god', 'Attendance records: admin'])),
                Tables\Filters\SelectFilter::make('verification')
                    ->label('Medio de verificación')
                    ->options(
                        [
                            'iOnline'  => 'iOnline',
                            'Finger'   => 'Huella',
                            'Password' => 'Contraseña',
                        ]
                    )
                    ->visible(fn () => auth()->user()->canAny(['be god', 'Attendance records: admin'])),
            ])
            ->actions([
                Tables\Actions\Action::make('markAsProcessed')
                    ->label('Sirh OK')
                    ->action(function ($record) {
                        $record->sirh_at      = now();
                        $record->rrhh_user_id = auth()->id();
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->visible(fn ($record) => is_null($record->sirh_at) && auth()->user()->canAny(['be god', 'Attendance records: admin'])),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()->canAny(['be god'])),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()->canAny(['be god'])),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
                Tables\Actions\BulkAction::make('markAsProcessedBulk')
                    ->label('Sirh OK')
                    ->action(function (Collection $records) {
                        $records->each(function ($record) {
                            if (is_null($record->sirh_at)) {
                                $record->sirh_at      = now();
                                $record->rrhh_user_id = auth()->id();
                                $record->save();
                            }
                        });
                    })
                    ->requiresConfirmation()
                    ->visible(fn () => auth()->user()->canAny(['be god', 'Attendance records: admin'])),
            ])
            ->defaultSort('record_at', 'desc')
            ->checkIfRecordIsSelectableUsing(callback: fn (AttendanceRecord $record): bool => $record->sirh_at === null);
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
            // 'create' => Pages\CreateAttendanceRecord::route('/create'),
            // 'edit' => Pages\EditAttendanceRecord::route('/{record}/edit'),
        ];
    }
}
