<?php
namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource\Pages;

use App\Filament\Clusters\TalentManagement;
use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource;
use App\Filament\Clusters\TalentManagement\Resources\TalentManagementResource;
use App\Models\Parameters\Parameter;
use App\Models\Rrhh\OrganizationalUnit;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;


class ReportByOrganizationalUnit extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    protected static string $resource = JobPositionProfileResource::class;

    protected static string $view = 'filament.clusters.talent-management.resources.job-position-profile-resource.pages.report-by-organizational-unit';

    // public function getOrganizationalUnitsProfiles(){
    //     return  OrganizationalUnit::whereHas('jobPositionProfiles')->get();
    // }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(function (Builder $query) {
                $query = OrganizationalUnit::where('establishment_id', Parameter::get('establishment', 'SSTarapaca'));


                return $query;
            })
            // ->query(fn() =>$this->getOrganizationalUnitsProfiles())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre ')
                    ->sortable(),
            ])

            ->actions([
                // Define aquí tus acciones
            ])
            ->bulkActions([
                // Define aquí tus acciones en bloque
            ]);
    }

}