<?php
namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource\Pages;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource;
use App\Filament\Clusters\TalentManagement\Resources\TalentManagementResource;
use App\Models\Parameters\Parameter;
use App\Models\Parameters\ApprovalStep;
use Filament\Resources\Components\Tab;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\Rrhh\OrganizationalUnit;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;


class ReportByOrganizationalUnit extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    protected static string $resource = JobPositionProfileResource::class;

    protected static string $view = 'filament.clusters.talent-management.resources.job-position-profile-resource.pages.report-by-organizational-unit';

    protected static ?string $title = 'Reporte de perfiles de cargo por unidad organizacional';

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),

        ];
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(function (Builder $query) {
                return OrganizationalUnit::query()
                    ->withCount('jobPositionProfiles') // Cuenta los perfiles asociados
                    // ->having('job_position_profiles_count', '>', 0)   // Incluye solo las unidades con al menos un perfil
                    ->where('establishment_id', Parameter::get('establishment', 'SSTarapaca'));
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Unidad Organizacional')
                    ->formatStateUsing(function ($state, $record) {
                        // Agrega guiones según el nivel de la unidad organizacional
                        return str_repeat('-', $record->level) . ' ' . $state;
                    }),
                Tables\Columns\TextColumn::make('job_position_profiles_count')
                    ->label('Cantidad de Perfiles de Cargo')
                    ->sortable(),
            ])
            ->paginated(false)
            ->filters(filters: [
                Tables\Filters\SelectFilter::make('ouCreator')
                ->relationship(name: 'creator', titleAttribute: 'name')
                    // ->options(
                    //     ApprovalStep::whereRelation('approvalFlow', 'class', 'App\Models\JobPositionProfiles\JobPositionProfile')
                    //         ->orderBy('order')
                    //         ->with('organizationalUnit')
                    //         ->get()
                    //         ->pluck('organizationalUnit.name', 'id')
                    // )
                    // ->query(fn(Builder $query): Builder => $query->where('is_featured', true))
                // Define aquí tus acciones
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                // Define aquí tus acciones
            ])
            ->bulkActions([
                // Define aquí tus acciones en bloque
            ]);
    }
}