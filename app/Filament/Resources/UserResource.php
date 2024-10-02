<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'SDGP';

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
                        ->columnSpan(3),
                    Forms\Components\TextInput::make('dv')
                        ->required()
                        ->disabledOn('edit')
                        ->maxLength(1),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(8),
                ]),
                Forms\Components\TextInput::make('fathers_family')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mothers_family')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->options(['male' => 'Masculino', 'female' => 'Femenino'])
                    ->default(null),
                Forms\Components\DatePicker::make('birthday'),
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Select::make('establishment_id')
                            ->label('Establecimiento')
                            ->options(\App\Models\Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
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
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->default(null)
                    ->columnSpanFull(),
                Forms\Components\Select::make('commune_id')
                    ->relationship('commune', 'name')
                    ->default(null),
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email_personal')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                // Forms\Components\TextInput::make('password')
                //     ->password()
                //     ->maxLength(255)
                //     ->default(null)
                //     ->hiddenOn('edit'),
                Forms\Components\TextInput::make('vc_link')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('vc_alias')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('active')
                    ->required(),
                Forms\Components\Toggle::make('absent')
                    ->required(),
                Forms\Components\Toggle::make('external')
                    ->required(),
                Forms\Components\Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('run')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Run copiado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->formatStateUsing(fn (string $state) => ucwords(strtolower($state)))
                    ->translateLabel()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('fathers_family')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mothers_family')
                //     ->searchable(),
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
                Tables\Columns\TextColumn::make('position')
                    ->translateLabel()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('birthday')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('vc_link')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('vc_alias')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
                    ->translateLabel()
                    ->sortable()
                    ->limit(30),
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
                Impersonate::make()
                    ->redirectTo(route('filament.intranet.pages.dashboard')),
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

    public static function getLabel(): string
    {
        return 'Usuario';
    }

    public static function getPluralLabel(): string
    {
        return 'Usuarios';
    }

}
