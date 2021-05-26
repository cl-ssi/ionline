<?php

namespace App\Http\Livewire\RequestForm;
use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\UnitOfMeasurement;
use App\Models\Parameters\BudgetItem;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class RequestFormCreate extends Component
{
    use WithFileUploads;
    public $article, $unitOfMeasurement, $technicalSpecifications, $quantity,
    $unitValue, $taxes, $totalValue, $lstUnitOfMeasurement, $title, $edit, $key;
    public $purchaseMechanism, $messagePM, $program, $justify, $totalDocument;
    public $items, $lstBudgetItem, $budget_item_id, $requestForm, $editRF, $deletedItems, $idRF;

    protected $rules = [
        'unitValue'           =>  'required|numeric|min:1',
        'quantity'            =>  'required|numeric|min:0.1',
        'article'             =>  'required',
        'unitOfMeasurement'   =>  'required',
        'taxes'               =>  'required',
        'budget_item_id'      =>  'required',
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
        'budget_item_id.required'     => 'Debe seleccionar un Item Presupuestario',
    ];

    public function mount($requestForm){
      $this->purchaseMechanism      = "";
      $this->totalDocument          = 0;
      $this->items                  = array();
      $this->deletedItems           = array();
      $this->title                  = "Agregar Item";
      $this->edit                   = false;
      $this->editRF                 = false;
      $this->lstUnitOfMeasurement   = UnitOfMeasurement::all();
      $this->lstBudgetItem          = BudgetItem::all();
      if(!is_null($requestForm)){
        $this->requestForm = $requestForm;
        $this->setRequestForm();
      }
    }

    private function setRequestForm(){
      $this->program            =   $this->requestForm->program;
      $this->justify            =   $this->requestForm->justification;
      $this->purchaseMechanism  =   $this->requestForm->purchase_mechanism;
      $this->editRF             =   true;
      $this->idRF               =   $this->requestForm->id;
      foreach($this->requestForm->itemRequestForms as $item)
        $this->setRequestService($item);
    }

    private function setRequestService($item){
      $this->items[]=[
            'id'                       => $item->id,
            'article'                  => $item->article,
            'unitOfMeasurement'        => $item->unit_of_measurement,
            'technicalSpecifications'  => $item->specification,
            'quantity'                 => $item->quantity,
            'unitValue'                => $item->unit_value,
            'taxes'                    => $item->tax,
            'budget_item_id'           => $item->budget_item_id,
            'totalValue'               => $item->quantity * $item->unit_value,
    ];
      $this->totalForm();
      $this->cancelRequestService();
    }

    public function deleteRequestService($key){
      if($this->editRF && array_key_exists('id',$this->items[$key]))
        $this->deletedItems[]=$this->items[$key]['id'];
      unset($this->items[$key]);
      $this->totalForm();
      $this->cancelRequestService();
    }

    public function editRequestService($key){
      $this->resetErrorBag();
      $this->title                    = "Editar Item Nro ". ($key+1);
      $this->edit                     = true;
      $this->article                  = $this->items[$key]['article'];
      $this->unitOfMeasurement        = $this->items[$key]['unitOfMeasurement'];
      $this->technicalSpecifications  = $this->items[$key]['technicalSpecifications'];
      $this->quantity                 = $this->items[$key]['quantity'];
      $this->unitValue                = $this->items[$key]['unitValue'];
      $this->taxes                    = $this->items[$key]['taxes'];
      $this->budget_item_id           = $this->items[$key]['budget_item_id'];
      $this->key                      = $key;
    }

    public function updateRequestService(){
      $this->validate();
      $this->edit                                         = false;
      $this->items[$this->key]['article']                 = $this->article;
      $this->items[$this->key]['unitOfMeasurement']       = $this->unitOfMeasurement;
      $this->items[$this->key]['technicalSpecifications'] = $this->technicalSpecifications;
      $this->items[$this->key]['quantity']                = $this->quantity;
      $this->items[$this->key]['unitValue']               = $this->unitValue;
      $this->items[$this->key]['taxes']                   = $this->taxes;
      $this->items[$this->key]['budget_item_id']          = $this->budget_item_id;
      $this->items[$this->key]['totalValue']              = $this->quantity * $this->unitValue;
      $this->totalForm();
      $this->cancelRequestService();
    }

    public function addRequestService(){
      $this->validate();
      $this->items[]=[
            'id'                       => null,
            'article'                  => $this->article,
            'unitOfMeasurement'        => $this->unitOfMeasurement,
            'technicalSpecifications'  => $this->technicalSpecifications,
            'quantity'                 => $this->quantity,
            'unitValue'                => $this->unitValue,
            'taxes'                    => $this->taxes,
            'budget_item_id'           => $this->budget_item_id,
            'totalValue'               => $this->quantity * $this->unitValue,
    ];
      $this->totalForm();
      $this->cancelRequestService();
    }

    public function cancelRequestService(){
      $this->title = "Agregar Item";
      $this->edit  = false;
      $this->resetErrorBag();
      $this->article=$this->technicalSpecifications=$this->quantity=$this->unitValue="";
      $this->taxes=$this->budget_item_id=$this->unitOfMeasurement="";
    }

   public function messageMechanism(){
      $this->messagePM = array();
      switch ($this->purchaseMechanism) {
          case "cm<1000":
              $this->messagePM[] = "Adjuntar ID Mercado Público";
              $this->messagePM[] = "Especificaciones Técnicas de Bien y/o Servicios";
              $this->messagePM[] = "Decretos Presupuestarios";
              $this->messagePM[] = "Convenios Mandatos";
              $this->messagePM[] = "Resoluciones Aprovatorias de Programas Ministeriales";
              break;
          case "cm>1000":
              $this->messagePM[] = "Bases Técnicas y Especificaciones Técnicas de Bien y/o Servicios";
              $this->messagePM[] = "Decretos Presupuestarios";
              $this->messagePM[] = "Convenios Mandatos";
              $this->messagePM[] = "Resoluciones Aprovatorias de Programas Ministeriales";
              break;
          case "lp":
              $this->messagePM[] = "Bases Técnicas y Especificaciones Técnicas de Bien y/o Servicios";
              $this->messagePM[] = "Decretos Presupuestarios";
              $this->messagePM[] = "Convenios Mandatos";
              $this->messagePM[] = "Resoluciones Aprovatorias de Programas Ministeriales";
              break;
          case "td":
              $this->messagePM[] = "Términos de Referencias y Especificaciones Técnicas de Bien y/o Servicios";
              $this->messagePM[] = "Decretos Presupuestarios";
              $this->messagePM[] = "Convenios Mandatos";
              $this->messagePM[] = "Resoluciones Aprovatorias de Programas Ministeriales";
              break;
          case "ca":
              $this->messagePM[] = "Especificaciones Técnicas de Bien y/o Servicios";
              $this->messagePM[] = "Decretos Presupuestarios";
              $this->messagePM[] = "Convenios Mandatos";
              $this->messagePM[] = "Resoluciones Aprovatorias de Programas Ministeriales";
              $this->messagePM[] = "Tres Cotizaciones (Opcional)";
              break;
          case "":
              break;
      }
    }

    public function totalForm(){
      $this->totalDocument = 0;
      foreach($this->items as $item){
        $this->totalDocument = $this->totalDocument + $item['totalValue'];}
    }

    public function saveRequestForm(){
      $this->validate(
        [ 'purchaseMechanism'            =>  'required',
          'program'                      =>  'required',
          'justify'                      =>  'required',
          'items'                        =>  'required'
        ],
        [ 'purchaseMechanism.required'   =>  'Seleccione un Mecanismo de Compra.',
          'program.required'             =>  'Ingrese un Programa Asociado.',
          'justify.required'             =>  'Campo Justificación de Adquisición es requerido',
          'items.required'               =>  'Debe agregar al menos un Item para Bien y/o Servicio'
        ],
      );
      $req = RequestForm::updateOrCreate(
        [
          'id'                    =>  $this->idRF,
        ],
        [
          'justification'         =>  $this->justify,
          'type_form'             =>  '1',
          'creator_user_id'       =>  Auth()->user()->id,
          'applicant_user_id'     =>  Auth()->user()->id,
          //'supervisor_user_id'    =>  Auth()->user()->id,
          'applicant_ou_id'       =>  Auth()->user()->organizationalUnit->id,
          'applicant_position'    =>  Auth()->user()->getPosition(),
          'estimated_expense'     =>  $this->totalDocument,
          'purchase_mechanism'    =>  $this->purchaseMechanism,
          'program'               =>  $this->program,
          'status'                =>  'created'
      ]);
      foreach($this->items as $item){
        $this->saveItem($item, $req->id);
      }
      if($this->editRF){
        ItemRequestForm::destroy($this->deletedItems);
        session()->flash('info', 'Formulario de requrimiento N° '.$req->id.' fue editado con exito.');
      }
      else{
        EventRequestform::createLeadershipEvent($req);
        EventRequestform::createFinanceEvent($req);
        EventRequestform::createSupplyEvent($req);
        session()->flash('info', 'Formulario de requrimiento N° '.$req->id.' fue creado con exito.');
      }
      return redirect()->to('/request_forms');
    }

    private function saveItem($item, $id){
        $req = ItemRequestForm::updateOrCreate(
          [
            'id'                    =>      $item['id'],
          ],
          [
            'request_form_id'       =>      $id,
            'article'               =>      $item['article'],
            'unit_of_measurement'   =>      $item['unitOfMeasurement'],
            'specification'         =>      $item['technicalSpecifications'],
            'quantity'              =>      $item['quantity'],
            'unit_value'            =>      $item['unitValue'],
            'tax'                   =>      $item['taxes'],
            'budget_item_id'        =>      $item['budget_item_id'],
            'expense'               =>      $item['totalValue']
      ]);
    }

    public function render(){
        $this->messageMechanism();
        return view('livewire.request-form.request-form-create');
    }
}
