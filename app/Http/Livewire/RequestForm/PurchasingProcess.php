<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseType;

class PurchasingProcess extends Component
{
  public $requestForm, $purchaseMechanism, $purchaseUnit, $purchaseType, $lstPurchaseType, $lstPurchaseUnit, $radioSource, $checkBoxStatus;
  public $arrayPurchaseMechanism=[['value'=>'']], $arrayPurchaseType=[['value'=>'']], $arrayPurchaseUnit=[['value'=>'']];
  public $lastKey, $selectedItems;
  public $arrayCheckBox, $arrayVista, $arrayBgTable;

    public function mount(RequestForm $requestForm){
        $this->requestForm        = $requestForm;
        $this->purchaseMechanism  = $requestForm->purchase_mechanism;
        $this->purchaseUnit       = $requestForm->purchaseUnit->id;
        $this->purchaseType       = $requestForm->purchaseType->id;
        $this->lstPurchaseType    = PurchaseType::all();
        $this->lstPurchaseUnit    = PurchaseUnit::all();
        $this->radioSource        = null;
        $this->configInitialParameters();
    }

    /*Esta funcion configura parametros iniciales*/
    private function configInitialParameters(){
        foreach($this->requestForm->itemRequestForms as $key => $item){
          $this->setArrayVista(false, $key);
          $this->setCheckBoxStatus('enabled', $key);
          $this->setArrayBgTable($key);
          $this->setArrayCheckBox(0, $key);
          $this->setPurchaseMechanism($this->purchaseMechanism, $key);
          $this->setPurchaseType($this->purchaseType, $key);
          $this->setPurchaseUnit($this->purchaseUnit, $key);
        }
    }

    /*Setea arrayVista en FAlSE, esto hace que no se muestre la informacion para
      completar bajo cada uno de los items en la tabla de bienes y/o servicios*/
    private function setArrayVista($status, $key){
      $this->arrayVista[$key]=$status;
    }

    /*Configura el color de fondo de las Filas en tabla de items.
      Los valores son clases css en el blade principal*/
    private function setArrayBgTable($key){
      if($key%2 >> 0)
        $this->arrayBgTable[$key] = 'bgTableLight';
      else
        $this->arrayBgTable[$key] = 'bgTableDark';
    }

    /*Funcion para configurar el estado(enabled, disabled) de los checkbox por items*/
    private function setCheckBoxStatus($status, $key){
        $this->checkBoxStatus[$key] = $status;
    }

    /*Esta funcion se ejecuta al hacer click en cada uno de los lapices de los items,
      esto permite mostrar o no el contenido editable de cada item*/
    public function btnShowMe($key){
        if($this->arrayVista[$key]==false)
          $this->setArrayVista(true, $key);
        else
          $this->setArrayVista(false, $key);
    }

    /*Proceso desencadenado al seleccionar un Radio Button:
    -Deshabilita el checkbox correspondiente al item del radiobutton seleccionado
    -Habilita el checkbox correspondiente al lastKey (checkbox deshabilitado anteriormente, si existe)*/
    public function selectRadioButton($key){
        if(!is_null($this->lastKey))
          $this->setCheckBoxStatus('enabled', $this->lastKey);
        $this->setCheckBoxStatus('disabled', $key);
        $this->lastKey=$key;
    }

    public function showAllItems(){
        foreach($this->requestForm->itemRequestForms as $key => $item)
          $this->setArrayVista(true, $key);
    }

    public function hideAllItems(){
        foreach($this->requestForm->itemRequestForms as $key => $item)
          $this->setArrayVista(false, $key);
    }

    /*Muestra los CheckBox seleccionados, correspondientes a los items
      para pegar el contenido del origen*/
    public function selectCheckBox($key){
      $this->selectedItems = '';
      foreach($this->arrayCheckBox as $item){
        if($item['value'])
          $this->selectedItems = $this->selectedItems.' '.$item['value'] . ' ';
      }
    }

    private function setArrayCheckBox($value, $key){
      $this->arrayCheckBox[$key]['value'] = $value;
    }

    private function setPurchaseMechanism($value, $key){
      $this->arrayPurchaseMechanism[$key]['value'] = $value;
    }

    private function setPurchaseType($value, $key){
      $this->arrayPurchaseType[$key]['value'] = $value;
    }

    private function setPurchaseUnit($value, $key){
      $this->arrayPurchaseUnit[$key]['value'] = $value;
    }

    public function pasteItems(){
      
    }

    public function resetError(){
        $this->resetErrorBag();
    }

    public function render(){
        return view('livewire.request-form.purchasing-process');
    }
}
