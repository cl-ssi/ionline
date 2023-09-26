<?php

namespace App\Http\Livewire\PurchasePlan;

use Livewire\Component;

use App\User;
use App\Models\Parameters\Program;
use App\Models\PurchasePlan\PurchasePlan;
use App\Models\PurchasePlan\PurchasePlanItem;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreatePurchasePlan extends Component
{
    public $idPurchasePlan, $userResponsibleId, $telephone, $email, $position, $subdirectorate, $organizationalUnit, 
        $subject, $period;

    /* Listeners */
    public $searchedUser, $searchedProgram, $items;
    protected $listeners = ['searchedUser', 'searchedProgram', 'savedItems'];

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
            'subject.required'              => 'Debe ingresar un asunto.',
            'period.required'               => 'Debe ingresar un periodo',
            'items.required'                => 'Debe ingresar al menos un item'
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
    }

    public function savedItems($items)
    {
      $this->items = $items;
    }

    public function savePurchasePlan($purchase_plan_status){
        $this->purchase_plan_status = $purchase_plan_status;

        $this->validateMessage = 'description';

        $validatedData = $this->validate([
            'userResponsibleId' => 'required',
            'telephone'         => 'required',
            'email'             => 'required',
            'position'          => 'required',
            'subject'           => 'required',
            'period'            => 'required',
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
                    'subdirectorate_id'         => 2, 
                    'subdirectorate'            => 'Subdirección de Gestión Asistencial',
                    'subject'                   => $this->subject,
                    'program_id'                => $this->searchedProgram->id,
                    'program'                   => $this->searchedProgram->name,
                    'status'                    => ($this->purchase_plan_status == 'save') ? 'save' : 'sent',
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

        return redirect()->route('purchase_plan.show', $purchasePlan->id);
    }

    private function setPurchasePlan(){
        if($this->purchasePlanToEdit){
            $this->idPurchasePlan       = $this->purchasePlanToEdit->id;
            $this->userResponsibleId    = $this->purchasePlanToEdit->user_responsible_id;
            $this->position             = $this->purchasePlanToEdit->position;
            $this->telephone            = $this->purchasePlanToEdit->telephone;
            $this->email                = $this->purchasePlanToEdit->email;
            $this->organizationalUnit   = $this->purchasePlanToEdit->organizationalUnit->name;
            $this->program_id           = $this->purchasePlanToEdit->program_id;
            $this->subject              = $this->purchasePlanToEdit->subject;
            $this->period               = $this->purchasePlanToEdit->period;
        }
    }

    public function mount($purchasePlanToEdit){
        if(!is_null($purchasePlanToEdit)){
            $this->purchasePlanToEdit = $purchasePlanToEdit;
            $this->setPurchasePlan();
        }
    }
}
