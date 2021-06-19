<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseType;
use App\Rrhh\Authority;
use Carbon\Carbon;
use App\User;

class PurchasingProcess extends Component
{
  public $requestForm, $purchase_mechanism, $purchaseUnit, $purchaseType, $lstPurchaseType, $lstPurchaseUnit, $vista, $index;

    public function mount(RequestForm $requestForm)
    {
      $this->requestForm        = $requestForm;
      $this->purchase_mechanism = $requestForm->purchase_mechanism;
      $this->purchaseUnit       = $requestForm->purchaseUnit->id;
      $this->purchaseType       = $requestForm->purchaseType->id;
      $this->lstPurchaseType    = PurchaseType::all();
      $this->lstPurchaseUnit    = PurchaseUnit::all();
      $this->vista              = false;
    }

    public function resetError()
    {
    }

    public function edit()
    {
      if(!$this->vista)
        $this->vista = true;
      else
        $this->vista = false;
    }

    public function render()
    {
        return view('livewire.request-form.purchasing-process');
    }
}
