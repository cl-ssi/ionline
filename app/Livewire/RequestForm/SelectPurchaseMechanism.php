<?php

namespace App\Livewire\RequestForm;

use Livewire\Component;
use App\Models\Parameters\PurchaseMechanism;
use App\Models\Parameters\PurchaseType;
use App\Models\RequestForms\RequestForm;

class SelectPurchaseMechanism extends Component
{
    public $selectedPurchaseMechanism;
    public $selectedPurchaseType;

    public $purchasesType;

    public $requestForm;

    /* Para editar y precargar los select */
    public $purchaseMechanismSelected = null;
    // public $purchaseTypeSelected = null;

    public function mount(){
        if($this->requestForm){
            $this->selectedPurchaseMechanism = $this->requestForm->purchase_mechanism_id;
            $this->purchasesType = PurchaseMechanism::find($this->selectedPurchaseMechanism)->purchaseTypes()->get();
            $this->selectedPurchaseType = $this->requestForm->purchase_type_id;
        }
    }

    public function render()
    {
        return view('livewire.request-form.select-purchase-mechanism',[
            'purchaseMechanisms' => PurchaseMechanism::all()
        ]);
    }

    public function updatedselectedPurchaseMechanism()
    {
        $this->purchasesType = PurchaseMechanism::find($this->selectedPurchaseMechanism)->purchaseTypes()->get();
    }

    public function savePurchaseMechanism(){

        RequestForm::updateOrCreate(
            [
                'id'                    =>  $this->requestForm->id
            ],
            [
                'purchase_mechanism_id' => $this->selectedPurchaseMechanism,
                'purchase_type_id'      => $this->selectedPurchaseType
            ]
        );

        $this->requestForm->load('purchasingProcess');
        if($this->requestForm->purchasingProcess)
            $this->requestForm->purchasingProcess()->update(
                [
                    'purchase_mechanism_id' => $this->selectedPurchaseMechanism, 
                    'purchase_type_id'      => $this->selectedPurchaseType,
                    'status'                => 'in_process'
                ]
            );

        session()->flash('success', 'Estimado Usuario/a: el Mecanismo de Compra fue editado con éxito.');
        return redirect()->route('request_forms.supply.purchase', $this->requestForm);
    }
}
