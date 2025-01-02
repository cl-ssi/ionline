<?php

namespace App\Filament\Clusters\Parameters\Resources;

use App\Filament\Clusters\Parameters;
use App\Filament\Clusters\Parameters\Resources\ApprovalFlowResource\Pages;
use App\Filament\Clusters\Parameters\Resources\ApprovalFlowResource\RelationManagers;
use App\Models\Establishment;
use App\Models\Parameters\ApprovalFlow;
use App\Models\Rrhh\OrganizationalUnit;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovalFlowResource extends Resource
{
    protected static ?string $model = ApprovalFlow::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Parameters::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('class')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('establishment_id')
                    ->relationship('establishment', 'name')
                    ->required(),
                Forms\Components\Repeater::make('steps')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('organizational_unit_id')
                            ->relationship()
                            ->options(OrganizationalUnit::pluck('name','id'))
                            ->hiddenOn('create'),
                        Forms\Components\Select::make('establishment_id')
                            ->options(fn (): array => Establishment::orderBy('name')->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->live()
                            ->required()
                            ->hiddenOn('edit'),
                        SelectTree::make('organizational_unit_id')
                            ->label('Unidad Organizacional')
                            ->relationship(
                                relationship: 'organizationalUnit',
                                titleAttribute: 'name',
                                parentAttribute: 'organizational_unit_id',
                                modifyQueryUsing: fn($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name'),
                                modifyChildQueryUsing: fn($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name')
                            )
                            ->searchable()
                            ->parentNullValue(null)
                            ->enableBranchNode()
                            ->defaultOpenLevel(1)
                            ->hiddenOn('edit'),
                    ])
                    ->columns(2)
                    ->orderColumn('order')
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('class')
                    ->searchable(),
                Tables\Columns\TextColumn::make('establishment.name')
                    ->numeric()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalFlows::route('/'),
            'create' => Pages\CreateApprovalFlow::route('/create'),
            'edit' => Pages\EditApprovalFlow::route('/{record}/edit'),
        ];
    }
}
