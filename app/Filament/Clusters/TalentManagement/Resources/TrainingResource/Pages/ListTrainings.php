<?php

namespace App\Filament\Clusters\TalentManagement\Resources\TrainingResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\TrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;

class ListTrainings extends ListRecords
{
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Redirigir si el usuario intenta acceder sin permiso
     */
    public function mount(): void
    {
        parent::mount();

        if ($this->activeTab === 'Todos' && !auth()->user()->can('Trainings: all')) {
            Redirect::route('filament.intranet.talent-management.resources.trainings.index');
        }
    }

    public function getTabs(): array
    {
        $tabs = [];

        $tabs['Mis Solicitudes'] = Tab::make()
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->where('user_id', auth()->id());
        });

        if (auth()->user()->can('Trainings: all')) {
            $tabs['Todos'] = Tab::make()
                ->modifyQueryUsing(function (Builder $query): Builder {
                    return $query; // No aplica ningún filtro
            });
        }

        return $tabs;
    }
}
