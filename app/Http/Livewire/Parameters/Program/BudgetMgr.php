<?php

namespace App\Http\Livewire\Parameters\Program;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Parameters\ProgramBudget;
use App\Models\Parameters\Program;
use App\Models\Parameters\Subtitle;

class BudgetMgr extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;

    public $budget;

    /** Listado de programas */
    public $programs;
    /** Listado de subtitulos */
    public $subtitles;

    public $year;
    public $selectedSubtitle;
    public $ammount;
    public $program;


    /**
     * mount
     */
    public function mount()
    {
        $this->programs = Program::orderBy('name')->pluck('name', 'id');
        $this->subtitles = Subtitle::orderBy('name')->pluck('name', 'id');
        $this->program = null; // Agrega esta línea
    }

    protected function rules()
    {
        return [
            'program' => 'required',
            'ammount' => 'required',
        ];
    }

    protected $messages = [
        'program' => 'El programa es requerido',
        'ammount' => 'El monto es requerido',

    ];

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function form(ProgramBudget $budget)
    {
        $this->budget = ProgramBudget::firstOrNew(['id' => $budget->id]);
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->budget->establishment_id = auth()->user()->organizationalUnit->establishment_id ?? null;
        $this->budget->program_id = $this->program ?? null;
        $this->budget->ammount = $this->ammount ?? null;
        $this->budget->save();
        $this->index();
    }

    public function delete(ProgramBudget $budget)
    {
        $budget->delete();
    }


    public function updatePrograms()
    {
        $queryPrograms = Program::query();
        if ($this->year) {
            $queryPrograms->where('period', $this->year);
        }
        if ($this->selectedSubtitle) {
            $queryPrograms->where('subtitle_id', $this->selectedSubtitle);
        }

        $filteredPrograms = $queryPrograms->orderBy('name')->pluck('name', 'id');
        $this->programs = $filteredPrograms;
    }

    public function render()
    {
        $budgets = ProgramBudget::latest()->paginate(25);
        return view('livewire.parameters.program.budget-mgr', [
            'budgets' => $budgets,
        ])->extends('layouts.bt4.app');
    }
}
