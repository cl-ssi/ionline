<?php

namespace App\Filament\Clusters\Indicators\Resources\ApsResource\RelationManagers;

use App\Models\Indicators\Aps;
use App\Models\Indicators\Indicator;
use DB;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndicatorsRelationManager extends RelationManager
{
    protected static string $relationship = 'indicators';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            // Forms\Components\Placeholder::make('id')
            //     ->content(fn ($record): ?string => $record->id),
            Forms\Components\TextInput::make('number')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('goal')
                ->maxLength(255)
                ->default(null),
            Forms\Components\Textarea::make('establishment_cods')
                ->columnSpan(4),

            Forms\Components\Textarea::make('name')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Textarea::make('numerator')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Textarea::make('numerator_source')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Textarea::make('numerator_cods')
                ->columnSpanFull(),
            Forms\Components\Textarea::make('numerator_cols')
                ->columnSpan(4),
            Forms\Components\TextInput::make('numerator_acum_last_year')
                ->numeric()
                ->default(null)
                ->columnSpan(2),
            Forms\Components\Textarea::make('denominator')
                ->columnSpanFull(),
            Forms\Components\Textarea::make('denominator_source')
                ->columnSpanFull(),
            Forms\Components\Textarea::make('denominator_cods')
                ->columnSpanFull(),
            Forms\Components\Textarea::make('denominator_cols')
                ->columnSpan(4),
            Forms\Components\TextInput::make('denominator_acum_last_year')
                ->numeric()
                ->default(null)
                ->columnSpan(2),
            Forms\Components\TextInput::make('denominator_values_by_commune')
                ->maxLength(255)
                ->default(null)
                ->columnSpan(2),
            Forms\Components\Toggle::make('precision')
                ->columnSpan(4),

            Forms\Components\TextInput::make('weighting_by_section')
                ->numeric()
                ->default(null),
            Forms\Components\TextInput::make('evaluated_section_states')
                ->maxLength(255)
                ->default(null),
            // Forms\Components\TextInput::make('indicatorable_id')
            //     ->required()
            //     ->numeric(),
            // Forms\Components\TextInput::make('indicatorable_type')
            //     ->required()
            //     ->maxLength(255),

            Forms\Components\TextInput::make('weighting')
                ->numeric()
                ->default(null),
            Forms\Components\TextInput::make('level')
                ->maxLength(255)
                ->default(null),
            Forms\Components\TextInput::make('population')
                ->maxLength(255)
                ->default(null),
            Forms\Components\TextInput::make('professional')
                ->maxLength(255)
                ->default(null),
        ])
        ->columns(columns: 6);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->wrap()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('weighting_by_section')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('evaluated_section_states')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('numerator_acum_last_year')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('denominator_acum_last_year')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('denominator_values_by_commune')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('indicatorable_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('indicatorable_type')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('goal')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('weighting')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('precision')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('level')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('population')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('professional')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('clone')
                    ->label('Clonar')
                    ->action(function (Indicator $record, array $data) {
                        DB::transaction(function () use ($record, $data) {
                            $newRecord = $record->replicate();
                            $newRecord->indicatorable_id = $data['aps_id'];
                            $newRecord->indicatorable_type = Aps::class;
                            $newRecord->created_at = now()->startOfYear();
                            $newRecord->save();
                        });

                        \Filament\Notifications\Notification::make()
                            ->title('Registro clonado exitosamente.')
                            ->success()
                            ->send();

                        // return redirect()->route('filament.intranet.indicators.resources.aps.edit', [
                        //     'record' => $data['aps_id'],
                        // ]);
                    })
                    ->form(function (Indicator $record) {
                        $apsSlug = $record->indicatorable->slug;
                        $currentYear = $record->indicatorable->year;
                    
                        return [
                            Forms\Components\Select::make('aps_id')
                                ->label('Seleccionar APS')
                                ->options(
                                    Aps::where('slug', $apsSlug)
                                        ->where('year', '!=', $currentYear)
                                        ->orderBy('year', 'desc')
                                        ->pluck('year', 'id')
                                )
                                ->required(),
                        ];
                    })
                    ->modalHeading('Clonar Indicador')
                    ->modalButton('Clonar')
                    ->icon('heroicon-o-document-duplicate')
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('number', 'asc');
    }
}
