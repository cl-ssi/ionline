<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\SignerResource\Pages;
use App\Filament\Clusters\Documents\Resources\Agreements\SignerResource\RelationManagers;
use App\Models\Documents\Agreements\Signer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SignerResource extends Resource
{
    protected static ?string $model = Signer::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static ?string $cluster = Documents::class;

    protected static ?string $modelLabel = 'firmante';

    protected static ?string $pluralModelLabel = 'firmantes';

    protected static ?string $navigationGroup = 'Convenios';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('appellative')
                    ->label('Tratamiento')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->label('Usuario')
                    ->relationship('user', 'full_name')
                    ->searchable(['full_name'])
                    ->required(),
                Forms\Components\Textarea::make('decree')
                    ->label('Decreto')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('appellative')
                    ->label('Tratamiento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.short_name')
                    ->label('Usuario'),
                Tables\Columns\TextColumn::make('decree')
                    ->label('Decreto')
                    ->wrap()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSigners::route('/'),
            'create' => Pages\CreateSigner::route('/create'),
            'edit' => Pages\EditSigner::route('/{record}/edit'),
        ];
    }
}
