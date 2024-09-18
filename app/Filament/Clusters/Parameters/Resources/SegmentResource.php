<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\SegmentResource\Pages;
use App\Filament\Clusters\Parameters\Resources\SegmentResource\RelationManagers;
use App\Models\Unspsc\Segment;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use GPBMetadata\Google\Type\Datetime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SegmentResource extends Resource
{
    protected static ?string $model = Segment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Parameters::class;

    protected static ?string $modelLabel = 'Segmento';

    protected static ?string $pluralModelLabel = 'Segmentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Código')
                    ->numeric()
                    ->disabled(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('experies_at')
                    ->label('Fecha Expiración'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn($state) => $state == 'Activo' ? 'success' : 'danger')
                    ->sortable()
                    ->searchable(),
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
                Filter::make('active')
                    ->label('Activo')
                    ->query(fn($query) => $query->whereNull('experies_at')),
                Filter::make('inactive')
                    ->label('Inactivo')
                    ->query(fn($query) => $query->whereNotNull('experies_at')),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSegments::route('/'),
            'create' => Pages\CreateSegment::route('/create'),
            'edit' => Pages\EditSegment::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
