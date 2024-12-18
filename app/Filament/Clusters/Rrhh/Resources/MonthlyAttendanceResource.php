<?php

namespace App\Filament\Clusters\Rrhh\Resources;

use App\Filament\Clusters\Rrhh;
use App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource\Pages;
use App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource\RelationManagers;
use App\Models\Rrhh\MonthlyAttendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonthlyAttendanceResource extends Resource
{
    protected static ?string $model = MonthlyAttendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Rrhh::class;

    protected static ?string $modelLabel = 'informe mensual';

    protected static ?string $pluralModelLabel = 'informes mensuales';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Asistencia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Textarea::make('records')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('report_date')
                    ->required(),
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
                Tables\Columns\TextColumn::make('date')
                    ->label('Periodo')
                    ->date('Y-m')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('report_date')
                //     ->date()
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
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                    ->url(fn (MonthlyAttendance $record) => route('rrhh.attendance.show', [$record->user_id,$record->date->toDateString()]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('date','desc')
            ->paginationPageOptions([5,10,25,50]);
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
            'index' => Pages\ListMonthlyAttendances::route('/'),
            'create' => Pages\CreateMonthlyAttendance::route('/create'),
            'edit' => Pages\EditMonthlyAttendance::route('/{record}/edit'),
        ];
    }
}
