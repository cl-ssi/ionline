<?php

namespace App\Filament\Clusters\Finance\Resources;

use App\Filament\Clusters\Finance;
use App\Filament\Clusters\Finance\Resources\TreasuryResource\Pages;
use App\Filament\Clusters\Finance\Resources\TreasuryResource\RelationManagers;
use App\Models\Finance\Treasury;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreasuryResource extends Resource
{
    protected static ?string $model = Treasury::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Finance::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $modelLabel = 'tesorería';

    protected static ?string $pluralModelLabel = 'tesorerías';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('treasureable_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('treasureable_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('resolution_folio')
                    ->label('Folio Resolucion')
                    ->maxLength(255),
                Forms\Components\DatePicker ::make('resolution_date')
                    ->label('Fecha Resolucion'),
                // Forms\Components\TextInput::make('resolution_file')
                //     ->label('Archivo Resolucion')
                //     ->maxLength(255),
                Forms\Components\TextInput::make('commitment_folio_sigfe')
                    ->label('Folio Compromiso Sigfe')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('commitment_date_sigfe')
                    ->label('Fecha Compromiso Sigfe'),
                // Forms\Components\TextInput::make('commitment_file_sigfe')
                //     ->label('Archivo Compromiso Sigfe')
                //     ->maxLength(255),
                Forms\Components\TextInput::make('accrual_folio_sigfe')
                    ->label('Folio Devengo Sigfe')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('accrual_date_sigfe')
                    ->label('Fecha Devengo Sigfe'),
                // Forms\Components\TextInput::make('accrual_file_sigfe')
                //     ->label('Archivo Devengo Sigfe')
                //     ->maxLength(255),
                Forms\Components\DatePicker::make('bank_receipt_date')
                    ->label('Fecha Comprobante Bancario'),
                // Forms\Components\TextInput::make('bank_receipt_file')
                //     ->label('Archivo Comprobante Bancario')
                //     ->maxLength(255),
                Forms\Components\Repeater::make('SupportFile')
                    ->relationship('supportFile')
                    ->label('Archivo')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'resolution_file' => 'Resolución',
                                'commitment_file_sigfe' => 'Compromiso Sigfe',
                                'accrual_file_sigfe' => 'Devengo Sigfe',
                                'bank_receipt_file' => 'Comprobante Bancario',
                            ])
                            ->required(),
                        Forms\Components\FileUpload::make('storage_path')
                            ->label('Archivo')
                            ->directory('ionline/finances/treasuries/support_documents')
                            ->storeFileNamesIn('name')
                            ->acceptedFileTypes(['application/pdf'])
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $set('supportFile.type', $state);
                                }
                            })
                            ->required(),
                    ])
                    ->defaultItems(0)
                    ->columns(2)
                    ->maxItems(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripcion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('treasureable.treasurySubject')
                    ->label('Asunto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('treasureable.modelName')
                    ->label('Tipo')
                    ->searchable(),
                
                // Tables\Columns\TextColumn::make('treasuryable_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('resolution_folio')
                    ->label('Folio Resolucion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resolution_date')
                    ->label('Fecha Resolucion')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('resolution_file')
                    ->label('Archivo Resolucion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commitment_folio_sigfe')
                    ->label('Folio Compromiso Sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commitment_date_sigfe')
                    ->label('Fecha Compromiso Sigfe')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('commitment_file_sigfe')
                    ->label('Archivo Compromiso Sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accrual_folio_sigfe')
                    ->label('Folio Devengo Sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accrual_date_sigfe')
                    ->label('Fecha Devengo Sigfe')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accrual_file_sigfe')
                    ->label('Archivo Devengo Sigfe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_receipt_date')
                    ->label('Fecha Comprobante Bancario')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank_receipt_file')
                    ->label('Archivo Comprobante Bancario')
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
            'index' => Pages\ListTreasuries::route('/'),
            'create' => Pages\CreateTreasury::route('/create'),
            'edit' => Pages\EditTreasury::route('/{record}/edit'),
        ];
    }
}
