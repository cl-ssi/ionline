<?php

namespace App\Livewire\Rrhh;

use App\Models\Rrhh\Absenteeism;
use App\Models\Rrhh\AbsenteeismType;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ListAbsenteeisms extends Component
{
    use WithPagination;

    public $activeTab = 'Mis ausentismos';
    public $tipo_de_ausentismo; // propiedad para el filtro
    public $con_aprobacion = 'con'; // propiedad para el filtro por aprobación
    public $approval_status = 'all';

    protected $paginationTheme = 'bootstrap'; // Usar Bootstrap para el estilo de la paginación

    public function mount()
    {
        if ( !auth()->user()->canany(['Users: absenteeism user', 'Users: absenteeism admin']) ) {
            throw new HttpException(501, 'No tiene permisos para acceder a este módulo');
        }

        if ( request()->has('activeTab') ) {
            $this->activeTab = request()->get('activeTab');
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage(); // Reinicia la paginación al cambiar de pestaña
    }

    public function updateSirhAt($absenteeismId)
    {
        $absenteeism = Absenteeism::find($absenteeismId);

        if ( $absenteeism ) {
            $absenteeism->sirh_at = $absenteeism->sirh_at ? null : now();
            $absenteeism->save();
        }
    }

    public function deletePendingAbsenteeism($absenteeismId)
    {
        $absenteeism = Absenteeism::with('approval')->find($absenteeismId);

        if ( $absenteeism && $absenteeism->approval && is_null($absenteeism->approval->status) ) {
            // Eliminar la aprobación primero
            $absenteeism->approval->delete();
            // Luego eliminar el ausentismo
            $absenteeism->delete();
            session()->flash('message', 'Ausentismo y aprobación eliminados exitosamente.');
        } else {
            session()->flash('error', 'No se puede eliminar un ausentismo que no está pendiente.');
        }
    }

    private function applyFilters($query)
    {
        $query->with('user', 'organizationalUnit', 'approval');

        if ($this->activeTab === 'Mis ausentismos') {
            $query->where('rut', auth()->id());
        } elseif ($this->activeTab === 'Ausentismos de mi unidad') {
            $query->where('codigo_unidad', auth()->user()->organizationalUnit->sirh_ou_id);
        }

        if ($this->tipo_de_ausentismo) {
            $query->where('absenteeism_type_id', $this->tipo_de_ausentismo);
        }

        $query->when($this->con_aprobacion, function ($query, $con_aprobacion) {
            match ($con_aprobacion) {
                'con' => $query->whereHas('approval'),
                'sin' => $query->whereDoesntHave('approval'),
                default => $query,
            };
        });

        if ($this->approval_status !== 'all') {
            $query->whereHas('approval', function ($query) {
                match ($this->approval_status) {
                    'null' => $query->whereNull('status'),
                    'true' => $query->where('status', true),
                    'false' => $query->where('status', false),
                };
            });
        }

        return $query;
    }

    public function render()
    {
        $absenteeisms = Absenteeism::query();
        $absenteeisms = $this->applyFilters($absenteeisms);

        return view('livewire.rrhh.list-absenteeisms', [
            'absenteeisms'     => $absenteeisms->orderBy('id', 'desc')->paginate(50),
            'absenteeismTypes' => AbsenteeismType::orderBy('name')->pluck('name', 'id'), // Obtener tipos de ausentismo
        ]);
    }

    public function export()
    {
        $absenteeisms = Absenteeism::query();
        $absenteeisms = $this->applyFilters($absenteeisms);
        $absenteeisms = $absenteeisms->whereNotNull('sirh_at')->get();

        $output = '';

        // Escribir encabezados
        $output .= implode('|', [
            'Rut',
            'Dv',
            'Número del cargo',
            'F.inicio',
            'F.término',
            'Dias permiso',
            'Medios dias',
            'Nº resolución',
            'F.resolución'
        ]) . "\n";

        // Escribir cada registro
        foreach ( $absenteeisms as $absenteeism ) {
            $output .= implode('|', [
                $absenteeism->rut,
                $absenteeism->dv,
                1, // Número del cargo, asumiendo que es siempre 1
                $absenteeism->finicio ? $absenteeism->finicio->format('dmY') : '',
                $absenteeism->ftermino ? $absenteeism->ftermino->format('dmY') : '',
                $absenteeism->total_dias_ausentismo ?? 0,
                0, // Medios días, asumir 0 si no se tiene este dato
                $absenteeism->n_resolucion ?? '',
                $absenteeism->fresolucion ?? ''
            ]) . "\n";
        }

        // Guardar el contenido para mostrarlo en la vista
        session()->flash('exportContent', $output);
    }
}
