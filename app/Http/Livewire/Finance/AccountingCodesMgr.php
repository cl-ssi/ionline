<?php

namespace App\Http\Livewire\Finance;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Finance\AccountingCode;

class AccountingCodesMgr extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;

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
        $this->form = false;
    }

    public function form(AccountingCode $accountingCode)
    {
        $this->accountingCode = AccountingCode::firstOrNew([ 'id' => $accountingCode->id]);
        $this->form = true;
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
