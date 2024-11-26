<?php

namespace App\Filament\Clusters\Documents\Resources\ActivityReports;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\ActivityReports\BinnacleResource\Pages;
use App\Filament\Clusters\Documents\Resources\ActivityReports\BinnacleResource\RelationManagers;
use App\Models\Documents\ActivityReports\Binnacle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BinnacleResource extends Resource
{
    protected static ?string $model = Binnacle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'bitácora';

    protected static ?string $pluralModelLabel = 'bitácoras';

    protected static ?string $navigationGroup = 'Documentos';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->displayFormat('Y-m')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.shortName')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBinnacles::route('/'),
            'create' => Pages\CreateBinnacle::route('/create'),
            'edit' => Pages\EditBinnacle::route('/{record}/edit'),
        ];
    }
}
