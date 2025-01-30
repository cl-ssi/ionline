<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements;

use App\Filament\Clusters\Documents;
use App\Filament\Clusters\Documents\Resources\Agreements\ProcessReportResource\Pages;
use App\Filament\Exports\Documents\Agreements\ProcessExporter;
use App\Models\Documents\Agreements\Process;
use App\Models\Documents\Approval;
use Carbon\Carbon;
use Filament\Forms\Get;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProcessReportResource extends Resource
{
    protected static ?string $model = Process::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $cluster = Documents::class;

    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $modelLabel = 'reporte proceso';

    protected static ?string $pluralModelLabel = 'reporte procesos';

    protected static ?int $navigationSort = 8;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function canAccess(): bool
    {
        return auth()->user()->canAny([
            'be god',
            'Agreement: admin',
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(ProcessExporter::class)
                    ->columnMapping(false),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('period')
                    ->label('Periodo')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('program.name')
                    ->label('Programa')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                /** Comuna o Establecimiento, ver como implementar eso, quizá con un atributo */
                Tables\Columns\TextColumn::make('commune.name')
                    ->label('Comuna')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                // Tables\Columns\TextColumn::make('establishments')
                //     ->label('Establecimientos')
                //     ->searchable()
                //     ->toggleable()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('program.resource_distribution_number')
                    ->label('Nº resolución de distribución de recursos')
                    ->wrapHeader()
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('program.resource_distribution_date')
                    ->label('Fecha resolución de distribución de recursos')
                    ->wrapHeader()
                    ->wrap()
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('days_elapsed')
                    ->label('Días transcurridos')
                    ->wrapHeader()
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->placeholder('Sin fecha de distribución de recursos.')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('program.subtitle.name')
                    ->label('Subtitulo')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Monto total')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('processType.name')
                    ->label('Tipo de proceso')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sended_revision_lawyer_at')
                    ->label('Fecha de envío a revisión jurídico')
                    ->wrapHeader()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('revision_by_lawyer_at')
                    ->label('Revisión por jurídico')
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sended_revision_commune_at')
                    ->label('Fecha de envío a revisión por comuna')
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('revision_by_commune_at')
                    ->label('Fecha revisión por comuna')
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sended_endorses_at')
                    ->label('Fecha de envío a vización')
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('endorses.initialsapproverat')
                    ->label('Visaciones')
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->toggleable()
                    ->fontFamily(FontFamily::Mono),
                // Tables\Columns\TextColumn::make('endorses.approver_at')
                //     ->label('Fecha visaciones')
                //     ->listWithLineBreaks()
                //     ->bulleted()
                //     ->placeholder('No description.')
                //     ->toggleable(),
                Tables\Columns\TextColumn::make('sended_to_commune_at')
                    ->label('Fecha de envío a comuna')
                    ->wrapHeader()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('returned_from_commune_at')
                    ->label('Fecha de recepción de comuna')
                    ->wrapHeader()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('approval.created_at')
                    ->label('Fecha envío a firma director')
                    ->wrapHeader()
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('approval.approver_at')
                    ->label('Fecha firma director')
                    ->wrapHeader()
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('number')
                    ->label('Número of partes')
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha de of partes')
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Tipo de proceso')
                    ->relationship('processType', 'name',
                        fn (Builder $query) => $query->where('is_certificate', false)->where('active', true))
                    ->label('Tipo de proceso'),

                Tables\Filters\SelectFilter::make('period')
                    ->label('Periodo')
                    ->options(array_combine(range(date('Y'), date('Y') - 5), range(date('Y'), date('Y') - 5))),
                Tables\Filters\SelectFilter::make('program_id')
                    ->label('Programa')
                    /**
                     * No pude hacer el filtro dependiente del año para solo mostrar los programas
                     * del periodo seleccionado arriba, te toca resolver Rojas
                     */
                    ->relationship(
                        name: 'program',
                        titleAttribute: 'name',
                        modifyQueryUsing: // que tengan procesos
                        fn (Builder $query, Get $get): Builder => $query->whereHas('processes'),
                    ),
                Tables\Filters\SelectFilter::make('comuna')
                    ->label('Comuna')
                    ->relationship(
                        name: 'commune',
                        titleAttribute: 'name',
                    )
                    ->searchable(),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->paginated([50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProcessesReport::route('/'),
        ];
    }
}
