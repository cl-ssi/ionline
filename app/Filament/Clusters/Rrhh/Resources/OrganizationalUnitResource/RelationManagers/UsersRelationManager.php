<?php

namespace App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\RelationManagers;

use App\Filament\Clusters\Rrhh\Resources\UserResource;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'Usuarios';

    public function form(Form $form): Form
    {
        return UserResource::form($form);
    }

    public function table(Table $table): Table
    {
        return UserResource::table($table);
    }

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\Grid::make(12)->schema([
    //                 Forms\Components\TextInput::make('id')
    //                     ->disabledOn('edit')
    //                     ->required()
    //                     ->numeric()
    //                     ->columnSpan(3),
    //                 Forms\Components\TextInput::make('dv')
    //                     ->required()
    //                     ->disabledOn('edit')
    //                     ->maxLength(1),
    //                 Forms\Components\TextInput::make('name')
    //                     ->required()
    //                     ->maxLength(255)
    //                     ->columnSpan(8),
    //             ]),
    //             Forms\Components\TextInput::make('fathers_family')
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('mothers_family')
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\Select::make('gender')
    //                 ->options(['male' => 'Masculino', 'female' => 'Femenino'])
    //                 ->default(null),
    //             Forms\Components\DatePicker::make('birthday'),
    //             Forms\Components\Grid::make(3)
    //                 ->schema([
    //                     Forms\Components\Select::make('establishment_id')
    //                         ->label('Establecimiento')
    //                         ->options(\App\Models\Parameter\Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id'))
    //                         ->default(auth()->user()->organizationalUnit->establishment_id)
    //                         ->live(),
    //                     SelectTree::make('organizational_unit_id')
    //                         ->label('Unidad Organizacional')
    //                         ->relationship(
    //                             relationship: 'organizationalUnit',
    //                             titleAttribute: 'name',
    //                             parentAttribute: 'organizational_unit_id',
    //                             modifyQueryUsing: fn($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name'),
    //                             modifyChildQueryUsing: fn($query, $get) => $query->where('establishment_id', $get('establishment_id'))->orderBy('name')
    //                         )
    //                         ->required()
    //                         ->searchable()
    //                         ->parentNullValue(null)
    //                         ->hiddenOptions([76])
    //                         ->enableBranchNode()
    //                         ->defaultOpenLevel(1)
    //                         ->columnSpan(2),
    //                 ]),
    //             Forms\Components\TextInput::make('position')
    //                 ->maxLength(255)
    //                 ->default(null),
    //             Forms\Components\TextInput::make('email')
    //                 ->email()
    //                 ->maxLength(255)
    //                 ->default(null),
    //             Forms\Components\TextInput::make('address')
    //                 ->maxLength(255)
    //                 ->default(null)
    //                 ->columnSpanFull(),
    //             Forms\Components\Select::make('commune_id')
    //                 ->relationship('commune', 'name')
    //                 ->default(null),
    //             Forms\Components\Select::make('country_id')
    //                 ->relationship('country', 'name')
    //                 ->default(null),
    //             Forms\Components\TextInput::make('phone_number')
    //                 ->tel()
    //                 ->maxLength(255)
    //                 ->default(null),
    //             Forms\Components\TextInput::make('email_personal')
    //                 ->email()
    //                 ->maxLength(255)
    //                 ->default(null),
    //             Forms\Components\Toggle::make('active')
    //                 ->required(),
    //             Forms\Components\Select::make('roles')
    //                 ->multiple()
    //                 ->relationship('roles', 'name'),
    //         ]);
    // }

    // public function table(Table $table): Table
    // {
    //     return $table
    //         ->recordTitleAttribute('name')
    //         ->columns([
    //             Tables\Columns\TextColumn::make('run')
    //                 ->searchable()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('shortName')
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('position')
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('email')
    //                 ->searchable(),
    //             Tables\Columns\IconColumn::make('active')
    //                 ->boolean(),
    //             Tables\Columns\TextColumn::make('created_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //             Tables\Columns\TextColumn::make('updated_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //             Tables\Columns\TextColumn::make('deleted_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->headerActions([
    //             Tables\Actions\CreateAction::make(),
    //         ])
    //         ->actions([
    //             Tables\Actions\EditAction::make(),
    //             Tables\Actions\DeleteAction::make(),
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }

}
