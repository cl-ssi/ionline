<?php
namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource\Pages;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource;
use App\Filament\Clusters\TalentManagement\Resources\TalentManagementResource;
use App\Models\Parameters\Parameter;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameters\ApprovalStep;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\Rrhh\OrganizationalUnit;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Support\Enums\FontFamily;
use Filament\Resources\Components\Tab;



class ReportByOrganizationalUnit extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = JobPositionProfileResource::class;

    protected static string $view = 'filament.clusters.talent-management.resources.job-position-profile-resource.pages.report-by-organizational-unit';

    protected static ?string $title = 'Reporte de perfiles de cargo por unidad organizacional';

    public $activeTab = 'general';



    protected function getTableQuery(): Builder
    {
        if ($this->activeTab === 'general') {
            return OrganizationalUnit::query()
                ->withCount('jobPositionProfiles')
                ->where('establishment_id', Parameter::get('establishment', 'SSTarapaca'));
        }
        if (in_array($this->activeTab, ['subdir_gestion_asistencial', 'subdir_desarrollo_personas', 'subdir_recursos_fisicos'])) {
            $unitIdMap = [
                'subdir_gestion_asistencial' => Parameter::get('ou', 'SubSDGA', Auth::user()->establishment_id),
                'subdir_desarrollo_personas' => Parameter::get('ou', 'SubRRHH', Auth::user()->establishment_id),
                'subdir_recursos_fisicos' => Parameter::get('ou', 'SDASSI', Auth::user()->establishment_id )
            ];

            $unitId = $unitIdMap[$this->activeTab];

            // Obtener los IDs de las unidades dependientes
            $unit = OrganizationalUnit::find($unitId);
            if ($unit) {
                $descendantIds = collect($unit->getDescendantUnitsArray())->pluck('id')->toArray();

                // Incluir el conteo de perfiles de cargo
                return OrganizationalUnit::query()
                    ->withCount('jobPositionProfiles')
                    ->whereIn('id', $descendantIds);
            }
        }

        return OrganizationalUnit::query(); // Query de fallback
    }


    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Unidad Organizacional')
                    ->fontFamily(FontFamily::Mono)
                    ->formatStateUsing(function ($state, $record) {
                        return str_repeat('-', $record->level) . ' ' . $state;
                    }),
                Tables\Columns\TextColumn::make('job_position_profiles_count')
                    ->label('Cantidad de Perfiles de Cargo')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}