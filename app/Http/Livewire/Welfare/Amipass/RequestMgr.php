<?php

namespace App\Http\Livewire\Welfare\Amipass;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Welfare\Amipass\BeneficiaryRequest;

class RequestMgr extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Variable para mostrar o no el show del objeto */
    public $element = false;
    public $beneficiaryRequest;
    public $filter = '';

    /**
     * Show
     */
    public function showElement($id)
    {
        $this->element = $id;
        $this->beneficiaryRequest = BeneficiaryRequest::find($id);
    }

    /**
     * Close Show
     */
    public function closeElement()
    {
        //app('debugbar')->info('close');
        $this->element = false;
        unset($this->beneficiaryRequest);
    }

    /**
     * Set Amipass Ok
     */
    public function amiOk($id)
    {
        BeneficiaryRequest::where('id', $id)
            ->update([
                'estado' => 'Ok',
                'ami_manager_id' => auth()->id(),
                'ami_manager_at' => now(),
            ]);

        session()->flash("success", "Listoco !");
    }

    public function searchBeneficiary()
    {
        $this->resetPage();
        $this->render();
    }


    public function render()
    {
        $requests = BeneficiaryRequest::search($this->filter)->latest()->paginate(100);
        return view('livewire.welfare.amipass.request-mgr', [
            'requests' => $requests,
        ])->extends('layouts.bt4.app');
    }
}
