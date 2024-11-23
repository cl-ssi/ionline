<?php

namespace App\Filament\Clusters\Rrhh\Resources;

use App\Filament\Clusters\Rrhh;
use App\Filament\Clusters\Rrhh\Resources\UserResource\Pages;
use App\Filament\Clusters\Rrhh\Resources\UserResource\RelationManagers;
use App\Models\Establishment;
use App\Models\User;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $cluster = Rrhh::class;

    protected static ?string $modelLabel = 'usuario';

    protected static ?string $pluralModelLabel = 'usuarios';
    
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)->schema([
                    Forms\Components\TextInput::make('id')
                        ->disabledOn('edit')
                        ->required()
                        ->numeric()
                        ->unique(ignoreRecord: true)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('dv')
                        ->required()
                        ->disabledOn('edit')
                        ->maxLength(1),
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('fathers_family')
                        ->label('Apellido paterno')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('mothers_family')
                        ->label('Apellido materno')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    Forms\Components\Select::make('gender')
                        ->label('Genero')
                        ->options(['male' => 'Masculino', 'female' => 'Femenino'])
                        ->default(null)
                        ->columnSpan(1),
                    Forms\Components\DatePicker::make('birthday')
                        ->label('F.Nacimiento')
                        ->columnSpan(2),
                ]),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->default(null)
                    ->hiddenOn('edit'),
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Select::make('establishment_id')
                            ->label('Establecimiento')
                            ->options(Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
                            ->default(auth()->user()->organizationalUnit->establishment_id)
                            ->live(),
                        SelectTree::make('organizational_unit_id')
                            ->label('Unidad Organizacional')
                            ->relationship(
                                relationship: 'organizationalUnit',
                                titleAttribute: 'name',
                                parentAttribute: 'organizational_unit_id',
                                modifyQueryUsing: fn($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name'),
                                modifyChildQueryUsing: fn($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name')
                            )
                            ->required()
                            ->searchable()
                            ->parentNullValue(null)
                            ->hiddenOptions([76])
                            ->enableBranchNode()
                            ->defaultOpenLevel(1)
                            ->columnSpan(2),
                    ]),
                Forms\Components\TextInput::make('position')
                    ->label('Función que desempeña')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->label('Email institucional')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('vc_link')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('vc_alias')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Grid::make(7)->schema([
                    Forms\Components\TextInput::make('address')
                        ->label('Dirección')
                        ->maxLength(255)
                        ->default(null)
                        ->columnSpan(2),
                    Forms\Components\Select::make('commune_id')
                        ->label('Coumuna')
                        ->relationship('commune', 'name')
                        ->default(null),
                    Forms\Components\Select::make('country_id')
                        ->label('País')
                        ->relationship('country', 'name')
                        ->default(null),
                    Forms\Components\TextInput::make('phone_number')
                        ->label('Teléfono personal')
                        ->tel()
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('email_personal')
                        ->label('Email personal')
                        ->email()
                        ->maxLength(255)
                        ->default(null)
                        ->columnSpan(2),
                ]),

                Forms\Components\Grid::make(6)->schema([
                    Forms\Components\Toggle::make('active')
                        ->label('Activo')
                        ->required(),
                    Forms\Components\Toggle::make('absent')
                        ->label('Ausente')
                        ->required(),
                    Forms\Components\Toggle::make('external')
                        ->label('Externo')
                        ->required(),
                ]),
                // Forms\Components\Repeater::make('roles')
                //     ->simple(
                //         Forms\Components\TextInput::make('email')
                //             ->email()
                //             ->required(),
                //     ),
                Forms\Components\Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->columnSpanFull()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScope(SoftDeletingScope::class))
            ->columns([
                Tables\Columns\TextColumn::make('run')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Run copiado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shortName')
                    ->label('Usuario')
                    ->sortable()
                    ->searchable(['full_name']),
                // Tables\Columns\TextColumn::make('gender')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('address')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('commune.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('phone_number')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('country.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('email')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('email_personal')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('birthday')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('vc_link')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('vc_alias')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
                    ->label('Unidad organizacional')
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('position')
                    ->label('Función')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->translateLabel()
                    ->boolean(),
                // Tables\Columns\IconColumn::make('gravatar')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('absent')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('external')
                //     ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\IconColumn::make('deleted_at')
                //     ->label('Estado')
                //     ->boolean()
                //     ->trueIcon('heroicon-o-trash')
                //     ->falseIcon('heroicon-o-check-circle')
                //     ->trueColor('danger')
                //     ->falseColor('success')
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('establishment_id')
                    ->label('Establecimiento')
                    ->options(Establishment::whereIn('id', explode(',',env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
                    ,
                Tables\Filters\SelectFilter::make('organizational_unit_id')
                    ->label('Unidad organizacional')
                    ->relationship('organizationalUnit','name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('roles')
                    ->label('Roles')
                    ->relationship('roles','name')
                    ->searchable()
                    ->preload()
                    ->visible(auth()->user()->can('be god')),
                Tables\Filters\SelectFilter::make('permissions')
                    ->label('Permisos')
                    ->relationship('permissions','name')
                    ->searchable()
                    ->preload()
                    ->visible(auth()->user()->can('be god')),
                // SelectTree::make('sent_to_ou_id')
                //     ->label('Unidad Organizacional')
                //     ->relationship(
                //         relationship: 'sentToOu',
                //         titleAttribute: 'name',
                //         parentAttribute: 'organizational_unit_id',
                //         modifyQueryUsing: fn($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name'),
                //         modifyChildQueryUsing: fn($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name')
                //     )
                //     ->searchable()
                //     ->parentNullValue(null)
                //     ->enableBranchNode()
                //     ->defaultOpenLevel(1)
                //     ->columnSpan(2)
                //     ,
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\EditAction::make(),
                Impersonate::make()
                    ->redirectTo(route('filament.intranet.pages.dashboard')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('full_name')
            ->paginationPageOptions([25,50,100]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TelephonesRelationManager::class,
            RelationManagers\RolesRelationManager::class,
            RelationManagers\PermissionsRelationManager::class,
            \App\Filament\RelationManagers\AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

}
