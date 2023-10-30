<?php

namespace App\Http\Livewire\PurchasePlan;

use Livewire\Component;

use App\User;
use App\Models\Parameters\Program;
use App\Models\PurchasePlan\PurchasePlan;
use App\Models\PurchasePlan\PurchasePlanItem;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;

use App\Models\Documents\Approval;
use App\Models\Parameters\Parameter;

class CreatePurchasePlan extends Component
{
    public $idPurchasePlan, 
        $userResponsibleId, 
        $telephone, 
        $email, 
        $position,
        $description,
        $purpose,
        $subdirectorate, 
        $organizationalUnit, 
        $subject,
        $program_id,
        $period;

    /* Listeners */
    public $searchedUser, $searchedProgram, $items, $deletedItems;
    protected $listeners = ['searchedUser', 'searchedProgram', 'savedItems', 'deletedItems'];

    public $readonly = "readonly";

    public $purchase_plan_status;

    /* PurchasePlan to edit */
    public $purchasePlanToEdit;

    protected function messages(){
        return [
            /* Mensajes para Allowance */
            'userResponsibleId.required'    => 'Debe ingresar funcionario responsable para plan de compra.',
            'telephone.required'            => 'Debe ingresar un teléfono.',
            'email.required'                => 'Debe ingresar un correo electrónico.',
            'position.required'             => 'Debe ingresar un cargo o función.',
            'description.required'          => 'Debe ingresar una descripción.',
            'purpose.required'              => 'Debe ingresar un propósito.',
            'subject.required'              => 'Debe ingresar un asunto.',
            'period.required'               => 'Debe ingresar un periodo',
            'items.required'                => 'Debe ingresar al menos un item',
            'program_id.required'           => 'Debe ingresar un programa'
        ];
    }

    public function render()
    {
        return view('livewire.purchase-plan.create-purchase-plan');
    }

    public function searchedUser(User $user){

        $this->searchedUser = $user;

        $this->userResponsibleId = $this->searchedUser->id;
        $this->position = $this->searchedUser->position;
        $this->telephone = ($this->searchedUser->telephones->count() > 0) ? $this->searchedUser->telephones->first()->minsal : '';
        $this->email = $this->searchedUser->email;

        $this->organizationalUnit = $this->searchedUser->organizationalUnit->name;
    }

    public function searchedProgram(Program $program){
        $this->searchedProgram = $program;
        $this->program_id = $program->id;
        $this->period = $program->period;
    }

    public function savedItems($items)
    {
      $this->items = $items;
    }

    public function deletedItems($items)
    {
      $this->deletedItems = $items;
    }

    private function setItems($item){
        $this->items[]=[
              'id'                       => $item->id,
              'product_id'               => $item->unspsc_product_id,
              'unitOfMeasurement'        => $item->unit_of_measurement,
              'technicalSpecifications'  => $item->specification,
              'quantity'                 => $item->quantity,
              'unitValue'                => $item->unit_value,
              'taxes'                    => $item->tax,
              'totalValue'               => $item->expense,
              'articleFile'              => $item->article_file
        ];
      }

    public function savePurchasePlan($purchase_plan_status){
        $this->purchase_plan_status = $purchase_plan_status;

        $this->validateMessage = 'description';

        $validatedData = $this->validate([
            'userResponsibleId' => 'required',
            'telephone'         => 'required',
            'email'             => 'required',
            'position'          => 'required',
            'description'       => 'required',
            'purpose'           => 'required',
            'subject'           => 'required',
            'period'            => 'required',
            'program_id'        => 'required',
            'items'             => 'required'
        ]);

        $purchasePlan = DB::transaction(function () {
            $purchasePlan = PurchasePlan::updateOrCreate(
                [
                    'id'  =>  $this->idPurchasePlan,
                ],
                [
                    'user_creator_id'           => Auth::user()->id, 
                    'user_responsible_id'       => $this->userResponsibleId, 
                    'position'                  => $this->position, 
                    'telephone'                 => $this->telephone, 
                    'email'                     => $this->email,            
                    'organizational_unit_id'    => $this->searchedUser->organizationalUnit->id,
                    'organizational_unit'       => $this->searchedUser->organizationalUnit->name,
                    'subject'                   => $this->subject,
                    'description'               => $this->description,
                    'purpose'                   => $this->purpose,
                    'program_id'                => $this->searchedProgram->id,
                    'program'                   => $this->searchedProgram->name.' '.$this->searchedProgram->period. ' subtítulo '.$this->searchedProgram->Subtitle->name,
                    // 'status'                    => ($this->purchase_plan_status == 'save') ? 'save' : 'sent',
                    'status'                    => $this->purchasePlanToEdit ? $this->purchasePlanToEdit->status : 'save',
                    'period'                    => $this->period
                ]
            );

            return $purchasePlan;
        });

        /* SE GUARDAN LOS ITEMS */
        foreach($this->items as $item){
            PurchasePlanItem::updateOrCreate(
                [
                    'id'                    =>  $item['id'],
                ],
                [
                    'unit_of_measurement'   =>  $item['unitOfMeasurement'],
                    'quantity'              =>  $item['quantity'],
                    'unit_value'            =>  $item['unitValue'],
                    'specification'         =>  $item['technicalSpecifications'],
                    'tax'                   =>  $item['taxes'],
                    'expense'               =>  $item['totalValue'],
                    'article_file'          =>  $item['articleFile'],
                    'unspsc_product_id'     =>  $item['product_id'],
                    'purchase_plan_id'      =>  $purchasePlan->id,
                ]
            );
        }

        /* SE CALCULA MONTO SOLICITADO */
        $purchasePlan->estimated_expense = $this->totalForm();
        $purchasePlan->save();

        if($this->deletedItems != null){
            PurchasePlanItem::destroy($this->deletedItems);
        }

        if($this->purchase_plan_status == 'sent'){
            /* SE ENVÍA AL MODULOS DE APROBACIONES */

            /* APROBACION CORRESPONDIENTE A JEFATURA DEPARTAMENTO O UNIDAD */
            $prev_approval = $purchasePlan->approvals()->create([
                "module"                => "Plan de Compras",
                "module_icon"           => "fas fa-shopping-cart",
                "subject"               => "Solicitud de Aprobación Jefatura",
                "sent_to_ou_id"        => $purchasePlan->organizational_unit_id,
                "document_route_name"   => "purchase_plan.show_approval",
                "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id])
            ]);

            /* APROBACION CORRESPONDIENTE A ABASTECIMIENTO */
            $prev_approval = $purchasePlan->approvals()->create([
                "module"                => "Plan de Compras",
                "module_icon"           => "fas fa-shopping-cart",
                "subject"               => "Solicitud de Aprobación Abastecimiento",
                "sent_to_ou_id"        => Parameter::where('module', 'ou')->where('parameter', 'AbastecimientoSSI')->first()->value,
                "document_route_name"   => "purchase_plan.show_approval",
                "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id]),
                "previous_approval_id"  => $prev_approval->id,
                "active"                => false
            ]);

            /* APROBACION CORRESPONDIENTE A FINANZAS */
            $prev_approval = $purchasePlan->approvals()->create([
                "module"                => "Plan de Compras",
                "module_icon"           => "fas fa-shopping-cart",
                "subject"               => "Solicitud de Aprobación Depto. Gestión Financiera",
                "sent_to_ou_id"        => Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value,
                "document_route_name"   => "purchase_plan.show_approval",
                "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id]),
                "previous_approval_id"  => $prev_approval->id,
                "active"                => false
            ]);

            /* APROBACION CORRESPONDIENTE A SDA */
            $prev_approval = $purchasePlan->approvals()->create([
                "module"                => "Plan de Compras",
                "module_icon"           => "fas fa-shopping-cart",
                "subject"               => "Solicitud de Aprobación Subdir. Recursos Físicos y Financieros",
                "sent_to_ou_id"        => Parameter::where('module', 'ou')->where('parameter', 'SDASSI')->first()->value,
                "document_route_name"   => "purchase_plan.show_approval",
                "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id]),
                "previous_approval_id"  => $prev_approval->id,
                "active"                => false
            ]);
        }

        return redirect()->route('purchase_plan.show', $purchasePlan->id);
    }

    private function setPurchasePlan(){
        if($this->purchasePlanToEdit){
            $this->searchedUser     = $this->purchasePlanToEdit->userResponsible;
            $this->searchedProgram  = $this->purchasePlanToEdit->programName;

            $this->idPurchasePlan       = $this->purchasePlanToEdit->id;
            $this->userResponsibleId    = $this->purchasePlanToEdit->user_responsible_id;
            $this->position             = $this->purchasePlanToEdit->position;
            $this->telephone            = $this->purchasePlanToEdit->telephone;
            $this->email                = $this->purchasePlanToEdit->email;
            $this->organizationalUnit   = $this->purchasePlanToEdit->organizationalUnit->name;
            $this->program_id           = $this->purchasePlanToEdit->program_id;
            $this->subject              = $this->purchasePlanToEdit->subject;
            $this->period               = $this->purchasePlanToEdit->period;
            $this->description          = $this->purchasePlanToEdit->description;
            $this->purpose              = $this->purchasePlanToEdit->purpose;

            foreach($this->purchasePlanToEdit->purchasePlanItems as $item){
                $this->setItems($item);
            }
        }
    }

    public function totalForm(){
        $total = 0;

        foreach($this->items as $item){
            $total += round($item['totalValue']);
        }

        return $total;
    }

    public function mount($purchasePlanToEdit){
        if(!is_null($purchasePlanToEdit)){
            $this->purchasePlanToEdit = $purchasePlanToEdit;
            $this->setPurchasePlan();
        }
    }
}
