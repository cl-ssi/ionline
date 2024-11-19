<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Drugs\CourtsResource\Pages;
use App\Filament\Clusters\Documents\Resources\Drugs\CourtsResource\RelationManagers;
use App\Models\Drugs\Court;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourtsResource extends Resource
{
    protected static ?string $model = Court::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $cluster = Documents::class;
    
    protected static ?string $modelLabel = 'juzgado';
    
    protected static ?string $pluralModelLabel = 'judgados';
    
    protected static ?string $navigationGroup = 'Drogas';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nombre')
                    ->maxLength(255),
                Forms\Components\TextInput::make('emails')
                    ->email()
                    ->label('Correo')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->label('Direccion')
                    ->default(null),
                Forms\Components\TextInput::make('commune')
                    ->required()
                    ->label('Comuna')
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                ->label('Estatus'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->wrap()
                    ->searchable()
                    ->label('Direccion'),
                Tables\Columns\TextColumn::make('emails')
                    ->label('Correos')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Estatus')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCourts::route('/'),
            'create' => Pages\CreateCourts::route('/create'),
            'edit' => Pages\EditCourts::route('/{record}/edit'),
        ];
    }
}
