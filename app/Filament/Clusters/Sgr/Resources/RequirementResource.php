<?php

namespace App\Filament\Clusters\Sgr\Resources;

use App\Filament\Clusters\Sgr;
use App\Filament\Clusters\Sgr\Resources\RequirementResource\Pages;
use App\Models\Establishment;
use App\Models\Sgr\Requirement;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// use App\Filament\Clusters\Sgr\Resources\RequirementResource\RelationManagers;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequirementResource extends Resource
{
    protected static ?string $model = Requirement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    protected static ?string $cluster = Sgr::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('labels')
                //     ->multiple()
                //     ->relationship('labels', 'name'),
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->columnSpanFull(),

                // Forms\Components\Select::make('event_type_id')
                //     ->relationship('eventType', 'name')
                //     ->required(),

                // Forms\Components\Select::make('user_id')
                //     ->relationship('user', 'name')
                //     ->required(),
                // Forms\Components\TextInput::make('parte_id')
                //     ->numeric(),
                // Forms\Components\TextInput::make('group_number')
                //     ->numeric(),
                // Forms\Components\Select::make('category_id')
                //     ->relationship('category', 'name')
                //     ->createOptionForm([
                //         Forms\Components\TextInput::make('name')
                //             ->required()
                //             ->maxLength(255),
                //         Forms\Components\ColorPicker::make('color')
                //             ->required(),
                //     ]),
                Forms\Components\Fieldset::make('firstEvent')
                    ->label('')
                    ->relationship('firstEvent')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('sent_to_establishment_id')
                                    ->label('Establecimiento')
                                    ->options(Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
                                    ->default(auth()->user()->establishment_id)
                                    ->live(),
                                SelectTree::make('sent_to_ou_id')
                                    ->label('Unidad Organizacional')
                                    ->relationship(
                                        relationship: 'sentToOu',
                                        titleAttribute: 'name',
                                        parentAttribute: 'organizational_unit_id',
                                        modifyQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('sent_to_establishment_id'))->orderBy('name'),
                                        modifyChildQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('sent_to_establishment_id'))->orderBy('name')
                                    )
                                    ->searchable()
                                    ->parentNullValue(null)
                                    ->enableBranchNode()
                                    ->defaultOpenLevel(1)
                                    ->columnSpan(2)
                                    ->live(),
                                Forms\Components\Section::make()
                                    ->description('O enviar a un usuario específico')
                                    ->schema([
                                        Forms\Components\Select::make('sent_to_user_id')
                                            ->relationship('sentToUser', 'full_name')
                                            ->label('Usuario (solo para casos en no sea una jefatura)')
                                            ->searchable()
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsed()
                                    ->compact(),
                            ]),
                        Forms\Components\Textarea::make('body')
                            ->label('Cuerpo')
                            ->required()
                            ->columnSpan(3)
                            ->autosize(),
                    ])
                    ->hiddenOn('edit'),
                Forms\Components\Toggle::make('priority')
                    ->label('Prioridad')
                    ->required(),
                Forms\Components\DateTimePicker::make('limit_at')
                    ->label('Fecha limite'),

                Forms\Components\FileUpload::make('files')
                    ->directory('sgr/attachments')
                    ->visibility('private'),

                // Forms\Components\Section::make()
                // ->schema([
                //     Forms\Components\Placeholder::make('created_at')
                //         ->label('Created at')
                //         ->content(fn (Order $record): ?string => $record->created_at?->diffForHumans()),

                //     Forms\Components\Placeholder::make('updated_at')
                //         ->label('Last modified at')
                //         ->content(fn (Order $record): ?string => $record->updated_at?->diffForHumans()),
                // ])

                Forms\Components\Repeater::make('events')
                    ->relationship()
                    ->hiddenOn('create')
                    ->schema([
                        Forms\Components\Select::make('event_type_id')
                            ->relationship('eventType', 'name')
                            ->required(),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('sent_to_establishment_id')
                                    ->label('Establecimiento')
                                    ->options(Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
                                    ->default(auth()->user()->establishment_id)
                                    ->live(),
                                SelectTree::make('sent_to_ou_id')
                                    ->label('Unidad Organizacional')
                                    ->relationship(
                                        relationship: 'sentToOu',
                                        titleAttribute: 'name',
                                        parentAttribute: 'organizational_unit_id',
                                        modifyQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('sent_to_establishment_id'))->orderBy('name'),
                                        modifyChildQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('sent_to_establishment_id'))->orderBy('name')
                                    )
                                    ->searchable()
                                    ->parentNullValue(null)
                                    ->enableBranchNode()
                                    ->defaultOpenLevel(1)
                                    ->columnSpan(2)
                                    ->live(),
                                Forms\Components\Section::make()
                                    ->description('O enviar a un usuario específico')
                                    ->schema([
                                        Forms\Components\Select::make('sent_to_user_id')
                                            ->relationship('sentToUser', 'full_name')
                                            ->label('Usuario (solo para casos en no sea una jefatura)')
                                            ->searchable()
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsed()
                                    ->compact(),
                            ]),
                        Forms\Components\DateTimePicker::make('limit_at')
                            ->label('Fecha limite'),
                        Forms\Components\FileUpload::make('files')
                            ->directory('sgr/attachments')
                            ->visibility('private'),
                        Forms\Components\Textarea::make('body')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpan(3)
                    ->addable(false)
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),

                Forms\Components\Repeater::make('participants')
                    ->label('Participantes')
                    ->relationship('participants')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('establishment_id')
                                    ->label('Establecimiento')
                                    ->options(Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
                                    ->default(auth()->user()->establishment_id)
                                    ->live(),
                                SelectTree::make('organizational_unit_id')
                                    ->label('Unidad Organizacional')
                                    ->relationship(
                                        relationship: 'organizationalUnit',
                                        titleAttribute: 'name',
                                        parentAttribute: 'organizational_unit_id',
                                        modifyQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name'),
                                        modifyChildQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name')
                                    )
                                    ->searchable()
                                    ->parentNullValue(null)
                                    ->enableBranchNode()
                                    ->defaultOpenLevel(1)
                                    ->columnSpan(2)
                                    ->live(),
                                Forms\Components\Section::make()
                                    ->description('O enviar a un usuario específico')
                                    ->schema([
                                        Forms\Components\Select::make('sent_to_user_id')
                                            ->relationship('sentToUser', 'full_name')
                                            ->label('Usuario (solo para casos en no sea una jefatura)')
                                            ->searchable()
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsed()
                                    ->compact(),
                            ]),
                    ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('priority')
                    ->boolean(),
                Tables\Columns\TextColumn::make('eventType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('limit_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('parte_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('group_number')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('category.name')
                //     ->numeric()
                //     ->sortable(),
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
                Tables\Actions\ViewAction::make(),
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
            'index'  => Pages\ListRequirements::route('/'),
            'create' => Pages\CreateRequirement::route('/create'),
            'view'   => Pages\ViewRequirement::route('/{record}'),
            'edit'   => Pages\EditRequirement::route('/{record}/edit'),
        ];
    }
}
