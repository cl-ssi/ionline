<?php
namespace App\Filament\RelationManagers;

use App\Models\Documents\Agreements\Process;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use OwenIt\Auditing\Models\Audit;

class AuditsRelationManager extends RelationManager
{
    protected static string $relationship = 'audits';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id'),
                Forms\Components\TextInput::make('user_id'),
                Forms\Components\TextInput::make('old_values'),
                Forms\Components\TextInput::make('new_values'),
                Forms\Components\TextInput::make('url'),
            ]);
    }

    protected function formatValue($value, string $key = ''): string 
    {
        if (is_null($value)) {
            return 'null';
        }

        if (is_array($value)) {
            return json_encode($value);
        }

        // Special handling for Process document_content
        if ($key === 'document_content' && $this->getOwnerRecord() instanceof Process) {
            $strippedContent = strip_tags($value);
            return mb_strlen($strippedContent) > 100 ? 
                mb_substr($strippedContent, 0, 100) . '...' : 
                $strippedContent;
        }

        if (is_object($value)) {
            if (method_exists($value, 'value')) {
                return $value->value;
            }
            if (method_exists($value, '__toString')) {
                return (string) $value;
            }
            return get_class($value);
        }

        return (string) $value;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('event')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.shortName')
                    ->searchable(['full_name'])
                    ->sortable(['full_name']),
                Tables\Columns\TextColumn::make('event')
                    ->description(function (Audit $record): HtmlString {
                        $modified = $record->getModified();
                        $formatted = [];

                        foreach ($modified as $key => $values) {
                            $oldValue = $this->formatValue($values['old'] ?? '', $key);
                            $newValue = $this->formatValue($values['new'] ?? '', $key);
                            
                            $formatted[] = "<b>$key</b>: $oldValue => $newValue";
                        }

                        return new HtmlString(implode('<br> ', $formatted));
                    }),
                Tables\Columns\TextColumn::make('url')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
