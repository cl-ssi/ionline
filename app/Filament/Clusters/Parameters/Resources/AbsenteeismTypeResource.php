<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\AbsenteeismTypeResource\Pages;
use App\Filament\Clusters\Parameters\Resources\AbsenteeismTypeResource\RelationManagers;
use App\Models\Rrhh\Absenteeism;
use App\Models\Rrhh\AbsenteeismType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Support\HtmlString;

class AbsenteeismTypeResource extends Resource
{
    protected static ?string $model = AbsenteeismType::class;

    protected static ?string $navigationIcon = 'bi-calendar-x-fill';

    protected static ?string $cluster = Parameters::class;

    protected static ?string $navigationGroup = 'Servicio';

    protected static ?string $modelLabel = 'tipos de ausentismos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->options(Absenteeism::distinct('tipo_de_ausentismo')->pluck('tipo_de_ausentismo', 'tipo_de_ausentismo')),
                Forms\Components\Toggle::make('discount')
                    ->label('Descuento'),
                Forms\Components\Toggle::make('half_day')
                    ->label('Medio Dia'),
                Forms\Components\Toggle::make('count_business_days')
                    ->label('Cuenta Dias Trabajados'),
                Forms\Components\TextInput::make('from')
                    ->label('Desde')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('over')
                    ->label('Hasta')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\CheckboxColumn::make('discount')
                    ->label('Descuento')
                    ->sortable(),
                Tables\Columns\CheckboxColumn::make('half_day')
                    ->label('Medio Dia')
                    ->sortable(),
                Tables\Columns\CheckboxColumn::make('count_business_days')
                    ->label(new HtmlString('Cuenta <br> Dias <br> Trabajados'))
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('from')
                    ->label('Sobre')
                    ->rules(['numeric'])
                    ->afterStateUpdated(function ($record, $state) {
                        \Filament\Notifications\Notification::make()
                            ->title('Desde Actualizado!')
                            ->body('Desde ha sido cambiado a ' . $state)
                            ->success()
                            ->send();
                    })
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('over')
                    ->label('Desde')
                    ->afterStateUpdated(function ($record, $state) {
                        \Filament\Notifications\Notification::make()
                            ->title('Hasta Actualizado!')
                            ->body('Hasta ha sido cambiado a ' . $state)
                            ->success()
                            ->send();
                    })
                    ->rules(['numeric'])
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
            ->filters([])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(50);
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
            'index' => Pages\ListAbsenteeismTypes::route('/'),
            'create' => Pages\CreateAbsenteeismType::route('/create'),
            'edit' => Pages\EditAbsenteeismType::route('/{record}/edit'),
        ];
    }
}
