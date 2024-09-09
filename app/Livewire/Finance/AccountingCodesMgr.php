<?php

namespace App\Livewire\Finance;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Finance\AccountingCode;

class AccountingCodesMgr extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $formActive = false;

    public $accountingCode;


    protected function rules()
    {
        return [
            'accountingCode.id' => 'required',
            'accountingCode.description' => 'required|min:1',
        ];
    }

    protected $messages = [
        'accountingCode.id.required' => 'El código es requerido.',
        'accountingCode.description.required' => 'La descripción es requerida.',
    ];

    public function index()
    {
        $this->resetErrorBag();
        $this->formActive = false;
    }

    public function showForm(AccountingCode $accountingCode)
    {
        $this->accountingCode = AccountingCode::firstOrNew([ 'id' => $accountingCode->id]);
        $this->formActive = true;
    }

    public function save()
    {
        $this->validate();
        $this->accountingCode->save();
        $this->index();
    }

    public function delete(AccountingCode $accountingCode)
    {
        $accountingCode->delete();
    }

    public function render()
    {
        $accountingCodes = AccountingCode::latest()->paginate(25);
        return view('livewire.finance.accounting-codes-mgr', [
            'accountingCodes' => $accountingCodes,
        ]);
    }
}
