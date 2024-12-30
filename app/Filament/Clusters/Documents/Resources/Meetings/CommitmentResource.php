<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Meetings\CommitmentResource\Pages;
use App\Filament\Clusters\Documents\Resources\Meetings\CommitmentResource\RelationManagers;
use App\Models\Meetings\Commitment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;

class CommitmentResource extends Resource
{
    protected static ?string $model = Commitment::class;

    protected static ?string $modelLabel = 'Compromiso';

    protected static ?string $pluralModelLabel = 'Compromisos';

    protected static ?string $navigationGroup = 'Reuniones';

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

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
                Tables\Columns\TextColumn::make('meeting_id')
                    ->label('N° Reunión')
                    ->sortable(),
                    // ->searchable(),
                Tables\Columns\TextColumn::make('meeting.date')
                    ->label('Fecha De Reunión')
                    ->dateTime('d-m-Y')
                    ->sortable(),
                    // ->searchable(),
                Tables\Columns\TextColumn::make('meeting.type')
                    ->label('Tipo')
                    ->getStateUsing(fn ($record) => $record->meeting->type_value)
                    ->alignment('center')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha De Compromiso')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable(),
                    // ->searchable(),
                Tables\Columns\TextColumn::make('meeting.userCreator.TinyName')
                    ->label('Creado Por'),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Prioridad')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'normal'    => 'success',
                        'urgente'   => 'danger',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('meeting.subject')
                    ->label('Asunto')
                    ->sortable(),
                Tables\Columns\TextColumn::make('meeting.description')
                    ->label('Descripción')
                    ->limit(100)
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_ou')
                    ->label('Funcionario / Unidad Organizacional')
                    ->getStateUsing(fn ($record) => $record->commitmentUser?->TinyName ?? $record->commitmentOrganizationalUnit?->name ?? '-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('closing_date')
                    ->label('Fecha Límite')
                    ->getStateUsing(fn ($record) => $record->closing_date 
                        ? $record->closing_date->format('d-m-Y') 
                        : 'Sin fecha límite')
                    ->sortable(),
                Tables\Columns\TextColumn::make('requirement.status')
                    ->label('Estado SGR')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'creado'        => 'gray',
                        'respondido'    => 'warning',
                        'cerrado'       => 'success',
                        'derivado'      => 'info',
                        'reabierto'     => 'primary',
                    })
                    ->alignment('center'),
                    
            ])
            ->defaultSort('meeting_id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view_sgr')
                    ->label('Ver SGR')
                    ->url(fn ($record) => route('requirements.show', $record->requirement->id))
                    ->icon('heroicon-o-eye')
                    ->color('secondary') // Puedes personalizar el color
                    ->openUrlInNewTab(), // Si deseas abrir en una nueva pestaña
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
            'index' => Pages\ListCommitments::route('/'),
            'create' => Pages\CreateCommitment::route('/create'),
            'edit' => Pages\EditCommitment::route('/{record}/edit'),
        ];
    }
}
