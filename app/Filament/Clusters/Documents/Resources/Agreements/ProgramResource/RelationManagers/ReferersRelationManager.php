<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\RelationManagers;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ReferersRelationManager extends RelationManager
{
    protected static string $relationship = 'referers';

    protected static ?string $title = 'Referentes';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('fullName')
                    ->label('Nombre'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        Forms\Components\Select::make('recordId')
                            ->label('Usuario')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                $terms = explode(' ', $search);
                                return User::query()
                                    ->where(function ($query) use ($terms) {
                                        foreach ($terms as $term) {
                                            $query->where(function ($subQuery) use ($term) {
                                                $subQuery->where('name', 'like', "%{$term}%")
                                                    ->orWhere('fathers_family', 'like', "%{$term}%")
                                                    ->orWhere('mothers_family', 'like', "%{$term}%")
                                                    ->orWhere('id', 'like', "%{$term}%");
                                            });
                                        }
                                    })
                                    ->get()
                                    ->mapWithKeys(fn ($user) => [$user->id => "{$user->name} {$user->fathers_family}"])
                                    ->toArray();
                            })
                            ->getOptionLabelUsing(fn ($value) => User::find($value) ? User::find($value)->name . ' ' . User::find($value)->fathers_family : 'N/A'),
                        Forms\Components\Toggle::make('external')->required(),
                    ])
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DetachBulkAction::make(),
                // ]),
            ]);
    }
}
