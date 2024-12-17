<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\Pages;
// use App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\RelationManagers;
use App\Models\Meetings\Meeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Pages\SubNavigationPosition;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $modelLabel = 'Reunión';

    protected static ?string $pluralModelLabel = 'Reuniones';

    protected static ?string $navigationGroup = 'Reuniones';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $cluster = Documents::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(fn ($record) => $record->status_value)
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Derivado SGR'  => 'info',
                        'Guardado'      => 'warning',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime('d-m-Y H:i:s'),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha Reunión')
                    ->dateTime('d-m-Y'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->getStateUsing(fn ($record) => $record->type_value)
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('userCreator.TinnyName')
                    ->label('Creado Por'),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commitments_number')
                    ->label('N° Compromisos')
                    ->getStateUsing(fn ($record) => $record->commitments()->count())
                    ->alignment('center')
            ])
            ->defaultSort('id', 'desc')
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
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }
}
