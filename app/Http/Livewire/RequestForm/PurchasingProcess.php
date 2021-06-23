<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseType;

class PurchasingProcess extends Component
{
  public $requestForm, $purchaseMechanism, $purchaseUnit, $purchaseType, $lstPurchaseType, $lstPurchaseUnit, $radioSource, $checkStatus;
  public $arrayVista=[['value'=>'']], $arrayPurchaseMechanism=[['value'=>'']], $arrayPurchaseType=[['value'=>'']], $arrayPurchaseUnit=[['value'=>'']];
  public $arrayBgTable=[['value'=>'']];
  public $subKey, $selectedItems;
  public $arrayCheckItem;

    public function mount(RequestForm $requestForm)
    {
        $this->requestForm        = $requestForm;
        $this->purchaseMechanism = $requestForm->purchase_mechanism;
        $this->purchaseUnit       = $requestForm->purchaseUnit->id;
        $this->purchaseType       = $requestForm->purchaseType->id;
        $this->lstPurchaseType    = PurchaseType::all();
        $this->lstPurchaseUnit    = PurchaseUnit::all();
        $this->radioSource        = -1;
        $this->configItems();
    }

    /*Esta funcion permite configurar varios parametros en cada item*/
    private function configItems()
    {
        foreach($this->requestForm->itemRequestForms as $key => $item){
          $this->setArrayVista(false, $key);
          $this->setCheckStatus('enabled', $key);
          $this->setArrayBgTable($key);
        }

    }

    /*Setea arrayVista en FAlSE, esto hace que no se muestre la informacion para
      completar bajo cada uno de los items en la tabla de bienes y/o servicios*/
    private function setArrayVista($status, $key)
    {
      $this->arrayVista[$key]['value']=$status;
    }

    /*Configura el color de fondo de las Filas en tabla de items.
      Los valores son clases css en el blade principal*/
    private function setArrayBgTable($key)
    {
      if($key%2 >> 0)
        $this->arrayBgTable[$key]['value'] = 'bgTableLight';
      else
        $this->arrayBgTable[$key]['value'] = 'bgTableDark';
    }

    /*Funcion para configurar el estado(enabled, disabled) de los checkbox por items*/
    private function setCheckStatus($status, $key)
    {
        $this->checkStatus[$key] = $status;
    }

    /*Esta funcion se ejecuta al hacer click en cada uno de los lapices de los items,
      esto permite mostrar o no el contenido editable de cada item*/
    public function showMe($key)
    {
        if($this->arrayVista[$key]['value']==false)
          $this->arrayVista[$key]['value'] = true;
        else
          $this->arrayVista[$key]['value'] = false;
    }

    /*Deshabilita el checkbox correspondiente al item del radiobutton seleccionado*/
    public function disableCheck($key)
    {
        if(!is_null($this->subKey))
          $this->setCheckStatus('enabled', $this->subKey);
        $this->setCheckStatus('disabled', $key);
        $this->subKey=$key;
    }

    public function showAllItems()
    {
        foreach($this->requestForm->itemRequestForms as $key => $item)
          $this->setArrayVista(true, $key);
    }

    public function hideAllItems()
    {
        foreach($this->requestForm->itemRequestForms as $key => $item)
          $this->setArrayVista(false, $key);
    }

    /*Tabla Item -> ID  empezar desde 1 */
    public function selectItem($key)
    {
      if(!$this->arrayCheckItem[$key]['value'])
        unset($this->arrayCheckItem[$key]);

      $this->selectedItems = '';
      foreach($this->arrayCheckItem as $item)
        $this->selectedItems = $this->selectedItems.($item['value']).' ';

/*      if($this->arrayCheckItem[$key]['value'])
      {
        //dd($this->arrayCheckItem[$key]['value']);

        //dd($this->arrayCheckItem[$key]['value']);

      }
        //if(is_null($item['value'])){
        //  unset($this->arrayCheckItem[$key]);
        //}else{*/
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
