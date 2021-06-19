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
  public $requestForm, $purchaseMechanism, $purchaseUnit, $purchaseType, $lstPurchaseType, $lstPurchaseUnit;
  public $arrayVista=[['value'=>'']], $arrayPurchaseMechanism=[['value'=>'']], $arrayPurchaseType=[['value'=>'']], $arrayPurchaseUnit=[['value'=>'']];
  public $arrayBgTable=[['value'=>'']];

    public function mount(RequestForm $requestForm)
    {
        $this->requestForm        = $requestForm;
        $this->purchaseMechanism = $requestForm->purchase_mechanism;
        $this->purchaseUnit       = $requestForm->purchaseUnit->id;
        $this->purchaseType       = $requestForm->purchaseType->id;
        $this->lstPurchaseType    = PurchaseType::all();
        $this->lstPurchaseUnit    = PurchaseUnit::all();
        $this->setArrayVista(false);
        $this->setArrayBgTable();
    }

    private function setArrayVista($val)
    {
        foreach($this->requestForm->itemRequestForms as $key => $item)
          $this->arrayVista[$key]['value']=$val;
    }

    private function setArrayBgTable()
    {
        foreach($this->requestForm->itemRequestForms as $key => $item){
          if($key%2 >> 0)
            $this->arrayBgTable[$key]['value'] = 'bgTableLight';
          else
            $this->arrayBgTable[$key]['value'] = 'bgTableDark';
        }
    }

    public function showMe($key)
    {
        if($this->arrayVista[$key]['value']==false)
          $this->arrayVista[$key]['value'] = true;
        else
          $this->arrayVista[$key]['value'] = false;
    }

    public function resetError()
    {
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.request-form.purchasing-process');
    }
}
