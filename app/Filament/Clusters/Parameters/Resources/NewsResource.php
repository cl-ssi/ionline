<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\NewsResource\Pages;
use App\Filament\Clusters\Parameters\Resources\NewsResource\RelationManagers;
use App\Models\Parameters\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Parameters::class;

    protected static ?string $modelLabel = 'noticia';

    protected static ?string $pluralModelLabel = 'noticias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->maxLength(255)
                    ->default(null)
                    ->required(),
                Forms\Components\DateTimePicker::make('until_at')
                    ->label('Fecha de expiración'),
                Forms\Components\Textarea::make('body')
                    ->label('Cuerpo')
                    ->rows(13),
                Forms\Components\FileUpload::make('image')
                    ->label('Imagen')
                    ->image() // restringe que sea solo de tipo imagen
                    ->directory('ionline/news')
                    ->imagePreviewHeight('310')
                    ->helperText('IMPORTANTE: Tamaño de la imagen 766x400')
                    ->rules(['dimensions:min_width=766,min_height=400,max_width=766,max_height=400']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('until_at')
                    ->label('Fecha de expiración')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.shortName')
                    ->label('Creador')
                    ->sortable(['full_name']),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
