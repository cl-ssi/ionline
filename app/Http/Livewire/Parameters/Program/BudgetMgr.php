<?php

namespace App\Http\Livewire\Parameters\Program;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Parameters\ProgramBudget;
use App\Models\Parameters\Program;

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

    /**
    * mount
    */
    public function mount()
    {
        $this->programs = Program::pluck('name','id');
    }

    protected function rules()
    {
        return [
            'budget.program_id' => 'required',
            'budget.ammount' => 'required|integer',
            'budget.period' => 'required',
            'budget.observation' => 'nullable',
            'budget.establishment_id' => 'nullable',
        ];
    }

    protected $messages = [
        'budget.program_id.required' => 'Debe seleccionar un programa.',
        'budget.ammount.required' => 'El monto es requerido.',
        'budget.period.required' => 'El periodo desde es requerido.',
    ];

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function form(ProgramBudget $budget)
    {
        $this->budget = ProgramBudget::firstOrNew([ 'id' => $budget->id]);
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->budget->establishment_id = auth()->user()->organizationalUnit->establishment_id ?? null;
        $this->budget->save();
        $this->index();
    }

    public function delete(ProgramBudget $budget)
    {
        $budget->delete();
    }

    public function render()
    {
        $budgets = ProgramBudget::latest()->paginate(25);
        return view('livewire.parameters.program.budget-mgr', [
            'budgets' => $budgets,
        ]);
    }
}
