<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\PurchaseMechanism;

class PurchasingProcess extends Component
{
  public $requestForm, $purchaseMechanism, $purchaseUnit, $purchaseType, $lstPurchaseType, $lstPurchaseUnit,
         $lstPurchaseMechanism, $radioSource, $checkBoxStatus;
  public $arrayPurchaseMechanism=[['value'=>'']], $arrayPurchaseType=[['value'=>'']], $arrayPurchaseUnit=[['value'=>'']];
  public $lastKey, $selectedItems;
  public $arrayCheckBox, $arrayVista, $arrayBgTable;
  public $idOC, $idInternalOC, $dateOC, $shippingDateOC, $idBigBuy, $pesoAmount, $dollarAmount,
         $ufAmount, $deliveryTerm, $deliveryDate, $idOffer, $idQuotation, $status;

    public function mount(RequestForm $requestForm){
        $this->requestForm            = $requestForm;
        $this->purchaseMechanism      = $requestForm->purchaseMechanism->id;
        $this->purchaseUnit           = $requestForm->purchaseUnit->id;
        $this->purchaseType           = $requestForm->purchaseType->id;
        $this->lstPurchaseType        = PurchaseType::all();
        $this->lstPurchaseUnit        = PurchaseUnit::all();
        $this->lstPurchaseMechanism   = PurchaseMechanism::all();
        $this->radioSource            = null;
        $this->configInitialParameters();
    }

    /*Esta funcion configura parametros iniciales*/
    private function configInitialParameters(){
        foreach($this->requestForm->itemRequestForms as $key => $item){
          $this->setArrayVista(false, $key);
          $this->setCheckBoxStatus('enabled', $key);
          $this->setArrayBgTable($key);
          $this->setArrayCheckBox(0, $key);
          $this->setArrayPurchaseMechanism($this->purchaseMechanism, $key);
          $this->setArrayPurchaseType($this->purchaseType, $key);
          $this->setArrayPurchaseUnit($this->purchaseUnit, $key);
          $this->setInitialValues($key);
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

    private function setArrayPurchaseMechanism($value, $key){
      $this->arrayPurchaseMechanism[$key]['value'] = $value;
    }

    private function setArrayPurchaseType($value, $key){
      $this->arrayPurchaseType[$key]['value'] = $value;
    }

    private function setArrayPurchaseUnit($value, $key){
      $this->arrayPurchaseUnit[$key]['value'] = $value;
    }

    public function pasteItems(){
        foreach($this->arrayCheckBox as $checkBox){
            if($checkBox['value'] && $checkBox['value'] != $this->radioSource)
              {
              $this->setArrayPurchaseMechanism($this->arrayPurchaseMechanism[($this->radioSource)-1]['value'], ($checkBox['value']-1));
              $this->setArrayPurchaseType($this->arrayPurchaseType[($this->radioSource)-1]['value'], ($checkBox['value']-1));
              $this->setArrayPurchaseUnit($this->arrayPurchaseUnit[($this->radioSource)-1]['value'], ($checkBox['value']-1));
              $this->idOC[$checkBox['value']-1]['value']            =   $this->idOC[($this->radioSource)-1]['value'];
              $this->idInternalOC[$checkBox['value']-1]['value']    =   $this->idInternalOC[($this->radioSource)-1]['value'];
              $this->dateOC[$checkBox['value']-1]['value']          =   $this->dateOC[($this->radioSource)-1]['value'];
              $this->shippingDateOC[$checkBox['value']-1]['value']  =   $this->shippingDateOC[($this->radioSource)-1]['value'];
              $this->idBigBuy[$checkBox['value']-1]['value']        =   $this->idBigBuy[($this->radioSource)-1]['value'];
              $this->pesoAmount[$checkBox['value']-1]['value']      =   $this->pesoAmount[($this->radioSource)-1]['value'];
              $this->dollarAmount[$checkBox['value']-1]['value']    =   $this->dollarAmount[($this->radioSource)-1]['value'];
              $this->ufAmount[$checkBox['value']-1]['value']        =   $this->ufAmount[($this->radioSource)-1]['value'];
              $this->deliveryTerm[$checkBox['value']-1]['value']    =   $this->deliveryTerm[($this->radioSource)-1]['value'];
              $this->deliveryDate[$checkBox['value']-1]['value']    =   $this->deliveryDate[($this->radioSource)-1]['value'];
              $this->idOffer[$checkBox['value']-1]['value']         =   $this->idOffer[($this->radioSource)-1]['value'];
              $this->idQuotation[$checkBox['value']-1]['value']     =   $this->idQuotation[($this->radioSource)-1]['value'];
          }
        }
    }

    private function setInitialValues($key){
      $this->idOC[$key]['value']            =   '';
      $this->idInternalOC[$key]['value']    =   '';
      $this->dateOC[$key]['value']          =   '';
      $this->shippingDateOC[$key]['value']  =   '';
      $this->idBigBuy[$key]['value']        =   '';
      $this->pesoAmount[$key]['value']      =   '';
      $this->dollarAmount[$key]['value']    =   '';
      $this->ufAmount[$key]['value']        =   '';
      $this->deliveryTerm[$key]['value']    =   '';
      $this->deliveryDate[$key]['value']    =   '';
      $this->idOffer[$key]['value']         =   '';
      $this->idQuotation[$key]['value']     =   '';
      $this->status[$key]['value']          =   'en_progreso';
    }

    public function resetError(){
        $this->resetErrorBag();
    }

    public function render(){
        return view('livewire.request-form.purchasing-process');
    }
}
