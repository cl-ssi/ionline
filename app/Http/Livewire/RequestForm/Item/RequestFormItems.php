<?php

namespace App\Http\Livewire\RequestForm\Item;

use App\Models\Parameters\UnitOfMeasurement;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestFormItems extends Component
{
    use WithFileUploads;

    public $article, $unitOfMeasurement, $technicalSpecifications, $quantity, $typeOfCurrency, $articleFile, $editRF,
            $unitValue, $taxes, $fileItem, $totalValue, $lstUnitOfMeasurement, $title, $edit, $key, $items, $totalDocument;

    protected $rules = [
        'unitValue'           =>  'required|numeric|min:1',
        'quantity'            =>  'required|numeric|min:0.1',
        'article'             =>  'required',
        'unitOfMeasurement'   =>  'required',
        //'fileItem'            =>  'required',
        'taxes'               =>  'required',
        'typeOfCurrency'      =>  'required'
        //'budget_item_id'      =>  'required',
    ];

    protected $messages = [
        'unitValue.required'          => 'Valor Unitario no puede estar vacio.',
        'unitValue.numeric'           => 'Valor Unitario debe ser numérico.',
        'unitValue.min'               => 'Valor Unitario debe ser mayor o igual a 1.',
        'quantity.required'           => 'Cantidad no puede estar vacio.',
        'quantity.numeric'            => 'Cantidad debe ser numérico.',
        'quantity.min'                => 'Cantidad debe ser mayor o igual a 0.1.',
        'article.required'            => 'Debe ingresar un Artículo.',
        'unitOfMeasurement.required'  => 'Debe seleccionar una Unidad de Medida',
        'taxes.required'              => 'Debe seleccionar un Tipo de Impuesto.',
        'typeOfCurrency.required'     => 'Debe seleccionar un Tipo de Moneda.',
        //'budget_item_id.required'     => 'Debe seleccionar un Item Presupuestario',
    ];

    public function addItem(){
      $this->validate();
      $this->items[]=[
            'id'                       => null,
            'article'                  => $this->article,
            'unitOfMeasurement'        => $this->unitOfMeasurement,
            'technicalSpecifications'  => $this->technicalSpecifications,
            'quantity'                 => $this->quantity,
            'unitValue'                => $this->unitValue,
            'taxes'                    => $this->taxes,
            //'budget_item_id'           => $this->budget_item_id,
            'totalValue'               => $this->quantity * $this->unitValue,
            'typeOfCurrency'           => $this->typeOfCurrency,
            'articleFile'              => $this->articleFile,
      ];
    //   dd($this->items);
      $this->estimateExpense();
      $this->cleanItem();
      $this->emit('savedItems', $this->items);
    }

    public function editItem($key)
    {
        $this->resetErrorBag();
        $this->title                    = "Editar Item Nro ". ($key+1);
        $this->edit                     = true;
        $this->article                  = $this->items[$key]['article'];
        $this->unitOfMeasurement        = $this->items[$key]['unitOfMeasurement'];
        $this->technicalSpecifications  = $this->items[$key]['technicalSpecifications'];
        $this->quantity                 = $this->items[$key]['quantity'];
        $this->unitValue                = $this->items[$key]['unitValue'];
        $this->taxes                    = $this->items[$key]['taxes'];
        //$this->budget_item_id           = $this->items[$key]['budget_item_id'];
        $this->key                      = $key;
    }

    public function updateItem()
    {
        $this->validate();
        $this->edit                                         = false;
        $this->items[$this->key]['article']                 = $this->article;
        $this->items[$this->key]['unitOfMeasurement']       = $this->unitOfMeasurement;
        $this->items[$this->key]['technicalSpecifications'] = $this->technicalSpecifications;
        $this->items[$this->key]['quantity']                = $this->quantity;
        $this->items[$this->key]['unitValue']               = $this->unitValue;
        $this->items[$this->key]['taxes']                   = $this->taxes;
        //$this->items[$this->key]['budget_item_id']          = $this->budget_item_id;
        $this->items[$this->key]['totalValue']              = $this->quantity * $this->unitValue;
        $this->estimateExpense();
        $this->cleanItem();
        $this->emit('savedItems', $this->items);
    }

    public function deleteItem($key)
    {
        if($this->editRF && array_key_exists('id',$this->items[$key]))
          $this->deletedItems[]=$this->items[$key]['id'];
        unset($this->items[$key]);
        $this->estimateExpense();
        $this->cleanItem();
        $this->emit('savedItems', $this->items);
    }

    public function estimateExpense()
    {
        $this->totalDocument = 0;
        foreach($this->items as $item){
          $this->totalDocument = $this->totalDocument + $item['totalValue'];}
    }

    public function cleanItem()
    {
        $this->title = "Agregar Item";
        $this->edit  = false;
        $this->resetErrorBag();
        $this->article = $this->technicalSpecifications = $this->quantity = $this->unitValue = "";
        $this->taxes = $this->budget_item_id = $this->unitOfMeasurement = "";
    }

    public function mount()
    {
        $this->totalDocument          = 0;
        $this->lstUnitOfMeasurement   = UnitOfMeasurement::all();
        $this->items                  = array();
        $this->title                  = "Agregar Item";
        $this->edit                   = false;
        $this->editRF                 = false;
    }

    public function render()
    {
        return view('livewire.request-form.item.request-form-items');
    }
}
