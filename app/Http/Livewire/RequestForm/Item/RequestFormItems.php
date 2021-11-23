<?php

namespace App\Http\Livewire\RequestForm\Item;

use App\Models\Parameters\UnitOfMeasurement;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestFormItems extends Component
{
    use WithFileUploads;

    public $article, $unitOfMeasurement, $technicalSpecifications, $quantity, $typeOfCurrency, $articleFile,
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
    }

    public function render()
    {
        return view('livewire.request-form.item.request-form-items');
    }
}
