<?php

namespace App\Filament\Clusters\Documents\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\DocumentResource\Pages;
use App\Filament\Clusters\Documents\Resources\DocumentResource\RelationManagers;
use App\Models\Documents\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $modelLabel = 'documento';

    protected static ?string $pluralModelLabel = 'documentos';

    protected static ?string $navigationGroup = 'Documentos';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $cluster = Documents::class;

    // protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('number')
                //    ->maxLength(50)
                //    ->default(null)
                //    ->disabled()
                //    ->columnSpan(2),
                Forms\Components\DatePicker::make('date')
                    ->columnSpan(2),
                Forms\Components\Select::make('type_id')
                    ->relationship('type', 'name', function ($query) {
                        return $query->where('doc_digital', true);
                    })
                    ->default(null)
                    ->columnSpan(3),
                Forms\Components\Toggle::make('reserved')
                    ->inline(false)
                    ->columnSpan(1),
                Forms\Components\Textarea::make('antecedent')
                    ->rows(3)
                    ->columnSpan(5),
                Forms\Components\TextInput::make('subject')
                    ->maxLength(255)
                    ->translateLabel()
                    ->default(null)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('from')
                    ->maxLength(255)
                    ->default(null)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('for')
                    ->maxLength(255)
                    ->default(null)
                    ->columnSpanFull(),
                Forms\Components\Radio::make('greater_hierarchy')
                    ->options([
                        'from' => 'De',
                        'for' => 'Para',
                    ])
                    ->inline()
                    ->required()
                    ->columnSpan(6),
                // TinyEditor::make('content')
                //     ->fileAttachmentsVisibility('public')
                //     ->fileAttachmentsDirectory('documents/generator/images')
                //     ->profile('ionline')
                //     ->columnSpanFull()
                //     ->showMenuBar()
                //     ->minHeight(940)
                //     ->required(),
                // TinyEditor::make('content')
                //     ->profile('ionline')
                //     // ->template('example')
                //     ->showMenuBar()
                //     ->translateLabel()
                //     ->required()
                //     ->minHeight(940)
                //     ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->translateLabel()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('distribution')
                    ->translateLabel()
                    ->rows(5)
                    ->columnSpan(6),
                Forms\Components\Textarea::make('responsible')
                    ->translateLabel()
                    ->rows(5)
                    ->columnSpan(6),
                Forms\Components\FileUpload::make('file')
                    ->translateLabel()
                    ->directory('ionline/documents/documents/')
                    ->deleteUploadedFileUsing(function ($record) {
                        \Illuminate\Support\Facades\Storage::delete($record->file);
                    })
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('internal_number')
                    ->numeric()
                    ->default(null)
                    ->columnSpan(2),
                // Forms\Components\Select::make('user_id')
                //     ->relationship('user', 'full_name')
                //     ->searchable()
                //     ->required(),
                // Forms\Components\Select::make('organizational_unit_id')
                //     ->relationship('organizationalUnit', 'name')
                //     ->required(),
                // Forms\Components\TextInput::make('file_to_sign_id')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\Select::make('establishment_id')
                //     ->relationship('establishment', 'name')
                //     ->default(null),
                // Forms\Components\TextInput::make('signature_id')
                //     ->numeric()
                //     ->default(null),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.name')
                    ->numeric()
                    ->sortable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('number')
                    ->translateLabel()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('internal_number')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('Y-m-d')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('antecedent')
                    ->searchable()
                    ->wrap()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->wrap()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('from')
                    ->label('De / Para')
                    ->description(fn (Document $record): string => $record->for?? '', position: 'above')
                    ->wrap()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('for')
                //     ->searchable(),
                // Tables\Columns\IconColumn::make('reserved')
                //     ->translateLabel()
                //     ->boolean()
                //     ->trueIcon('heroicon-c-lock-closed')
                //     ->falseIcon(''),
                // Tables\Columns\TextColumn::make('greater_hierarchy'),
                // Tables\Columns\TextColumn::make('file')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('user.short_name')
                    ->numeric()
                    ->sortable()
                    ->wrap()
                    ->translateLabel(),
                // Tables\Columns\TextColumn::make('organizationalUnit.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('file_to_sign_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('establishment.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('signature_id')
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
                Tables\Actions\Action::make('pdf') 
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-document')
                    ->url(fn (Document $record) => route('documents.show', $record))
                    ->openUrlInNewTab(), 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
