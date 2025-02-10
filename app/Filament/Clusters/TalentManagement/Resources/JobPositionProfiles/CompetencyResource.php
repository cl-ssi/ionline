<?php

namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\CompetencyResource\Pages;
use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\CompetencyResource\RelationManagers;
use App\Models\JobPositionProfiles\Competency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;

class CompetencyResource extends Resource
{
    protected static ?string $model = Competency::class;

    protected static ?string $modelLabel = 'Diccionario de Competencias';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = TalentManagement::class;

    protected static ?string $navigationGroup = 'Perfiles de Cargo';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('active_from')
                    ->label('Vigencia desde'),
                Forms\Components\DatePicker::make('active_to')
                    ->label('Vigencia hasta'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->extraAttributes(['class' => 'whitespace-normal']),
                Tables\Columns\TextColumn::make('active_from')
                    ->label('Vigencia desde')
                    ->dateTime('d-m-Y'),
                Tables\Columns\TextColumn::make('active_to')
                    ->label('Vigencia hasta')
                    ->dateTime('d-m-Y'),
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
            'index' => Pages\ListCompetencies::route('/'),
            'create' => Pages\CreateCompetency::route('/create'),
            'edit' => Pages\EditCompetency::route('/{record}/edit'),
        ];
    }
}
