<?php

namespace App\Filament\Clusters\Rrhh\Resources;

use App\Filament\Clusters\Rrhh;
use App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\Pages;
use App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\RelationManagers;
use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationalUnitResource extends Resource
{
    protected static ?string $model = OrganizationalUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $cluster = Rrhh::class;

    protected static ?string $modelLabel = 'unidad organizacional';

    protected static ?string $pluralModelLabel = 'unidades organizacionales';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(8)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(7),
                        Forms\Components\TextInput::make('level')
                            ->numeric()
                            ->default(null)
                            ->columnSpan(1),
                    ]),
                Forms\Components\Fieldset::make('Dependencia')
                    ->schema([
                        Forms\Components\Select::make('establishment_id')
                            ->label('Establecimiento')
                            ->options(Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
                            ->default(auth()->user()->organizationalUnit->establishment_id)
                            ->live(),
                        SelectTree::make('organizational_unit_id')
                            ->label('Unidad Organizacional')
                            ->relationship(relationship: 'father',
                                titleAttribute: 'name',
                                parentAttribute: 'organizational_unit_id',
                                modifyQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name'),
                                modifyChildQueryUsing: fn ($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name')
                            )
                            ->searchable()
                            ->parentNullValue(null)
                            ->enableBranchNode()
                            ->defaultOpenLevel(1)
                            ->columnSpan(2),
                    ])
                    ->columns(3),
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('sirh_function')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('sirh_ou_id')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('sirh_cost_center')
                            ->maxLength(255)
                            ->default(null),
                    ]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('manager')
                            ->label('Autoridad')
                            ->content(fn (OrganizationalUnit $record): ?string => $record->manager?->full_name),
                        Forms\Components\Placeholder::make('delegate')
                            ->label('Delegado/a')
                            ->content(fn (OrganizationalUnit $record): ?string => $record->delegate?->full_name),
                        Forms\Components\Placeholder::make('secretary')
                            ->label('Secretario/a')
                            ->content(fn (OrganizationalUnit $record): ?string => $record->secretary?->full_name),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextInputColumn::make('order'),
                Tables\Columns\TextColumn::make('name')
                    ->prefix(fn (OrganizationalUnit $record): string => str_repeat('- ', $record->level))
                    ->searchable()
                    ->fontFamily(FontFamily::Mono),
                // Tables\Columns\TextColumn::make('level')
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
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->paginated(false)
            ->defaultSort('order');
    }

    // public static function getRecordSubNavigation(\Filament\Pages\Page $page): array
    // {
    //     return $page->generateNavigationItems([
    //         // Pages\ViewOrganizationalUnit::class,
    //         Pages\EditOrganizationalUnit::class,
    //     ]);
    // }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
            RelationManagers\AuthoritiesRelationManager::class,
            RelationManagers\SubrogationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrganizationalUnits::route('/'),
            'create' => Pages\CreateOrganizationalUnit::route('/create'),
            'edit'   => Pages\EditOrganizationalUnit::route('/{record}/edit'),
            // 'view' => Pages\ViewOrganizationalUnit::route('/{record}'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('manager.full_name')
                    ->label('Autoridad'),
            ]);
    }
}
