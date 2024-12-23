<?php

namespace App\Filament\Clusters\Documents\Resources;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\ParteResource\Pages;
use App\Models\Documents\Parte;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ParteResource extends Resource
{
    protected static ?string $model = Parte::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'parte';

    protected static ?string $pluralModelLabel = 'partes';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationGroup = 'Documentos';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('entered_at')
                    ->label('Fecha de Ingreso')
                    ->required()
                    ->default(now()),
                Forms\Components\Select::make('type_id')
                    ->label('Tipo')
                    ->required()
                    ->relationship('type', 'name'),
                Forms\Components\Toggle::make('reserved')
                    ->label('Reservado')
                    ->inline(false),
                Forms\Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->required(),
                Forms\Components\TextInput::make('number')
                    ->label('Número')
                    ->numeric(),
                Forms\Components\TextInput::make('origin')
                    ->label('Origen')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('subject')
                    ->label('Asunto')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('important')
                    ->label('Importante'),
                Forms\Components\Repeater::make('files')
                    ->label('Archivo')
                    ->relationship()
                    ->schema([
                        Forms\Components\FileUpload::make('file'),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('correlative')
                    ->label('correlativo')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('entered_at')
                    ->label('Fecha de Ingreso')
                    ->dateTime('Y-m-d-H:i')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type.name')
                    ->label('Tipo')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->label('Numero')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('origin')
                    ->label('Origen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->label('Asunto'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('última Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                /* Tables\Columns\TextColumn::make('deleted_at')
                    ->label('F. Eliminación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), */
            ])
            ->filters([
                Tables\Filters\Filter::make('important')
                    ->query(fn (Builder $query): Builder => $query->where('important', true))
                    ->label('Marcados como urgentes'),

                Tables\Filters\Filter::make('without_sgr')
                    ->query(fn (Builder $query): Builder => $query->filter('without_sgr', true))
                    ->label(' Solo aquellos sin derivación'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('correlative', 'desc');
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
            'index'  => Pages\ListPartes::route('/'),
            'create' => Pages\CreateParte::route('/create'),
            'edit'   => Pages\EditParte::route('/{record}/edit'),
        ];
    }
}
