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
use Filament\Forms\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Forms\Components\FileUpload;

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
            Forms\Components\Section::make('Descripción reunión')
                // ->description('Prevent abuse by limiting the number of requests per period')
                ->schema([
                    Grid::make(12)->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Fecha Reunión')
                            ->columnSpan(3)
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'extraordinaria'    => 'Extraordinaria', 
                                'no extraordinaria' => 'No extraordinaria',
                                'lobby' => 'Lobby',
                            ])
                            ->default(null)
                            ->required()
                            ->columnSpan(3),
                        Forms\Components\TextInput::make('subject')
                            ->label('Asunto')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('mechanism')
                            ->label('Medio')
                            ->options([
                                'videoconferencia'  => 'Videoconferencia',
                                'presencial'        => 'Presencial',
                            ])
                            ->default(null)
                            ->required()
                            ->columnSpan(3),
                        Forms\Components\TimePicker::make('start_at')
                            ->label('Fecha Hora inicio')
                            ->seconds(false) // Restringe la selección solo a horas y minutos
                            ->columnSpan(3)
                            ->required(),
                        Forms\Components\TimePicker::make('end_at')
                            ->label('Fecha Hora término')
                            ->seconds(false) // Restringe la selección solo a horas y minutos
                            ->columnSpan(3)
                            ->required(),
                        Forms\Components\Group::make()
                            ->relationship('file')
                            ->schema([
                                Forms\Components\FileUpload::make('storage_path')
                                    ->label('Adjunto')
                                    ->directory('/ionline/meetings/attachments') // Directorio donde se guardarán los archivos,
                                    ->downloadable()
                                    ->columnSpan(9),
                            ])
                            ->columnSpan(9),
                    ]),
                    
                ]),

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
