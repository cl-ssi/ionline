<?php

namespace App\Livewire\PurchasePlan;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use App\Models\Parameters\Program;
use App\Models\PurchasePlan\PurchasePlan;
use App\Models\PurchasePlan\PurchasePlanItem;
use Illuminate\Support\Facades\DB;
use App\Models\Parameters\Parameter;
use Livewire\WithFileUploads;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class CreatePurchasePlan extends Component
{
    use WithFileUploads;

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
        $period,
        $disabled;

    /* Listeners */
    public $searchedUser, $searchedProgram, $items, $deletedItems;

    public $readonly = "readonly";

    public $purchase_plan_status;

    /* PurchasePlan to edit */
    public $purchasePlanToEdit;

    public $validateMessage;

    /* Archivos */
    public $idFile;
    public $fileName;
    public $fileStoragePath;
    public $fileAttached;
    public $files = array();
    public $key;
    public $deleteFileMessage;

    public $iterationFileClean = 0;

    protected function messages(){
        return [
            /* Mensajes para Formulario Plan de Compras */
            'userResponsibleId.required'    => 'Debe ingresar funcionario responsable para plan de compra.',
            'telephone.required'            => 'Debe ingresar un teléfono.',
            'email.required'                => 'Debe ingresar un correo electrónico.',
            'position.required'             => 'Debe ingresar un cargo o función.',
            'description.required'          => 'Debe ingresar una descripción.',
            'purpose.required'              => 'Debe ingresar un propósito.',
            'subject.required'              => 'Debe ingresar un asunto.',
            'period.required'               => 'Debe ingresar un periodo',
            'items.required'                => 'Debe ingresar al menos un item',
            'program_id.required'           => 'Debe ingresar un programa',

            /* Mensajes para archivos */
            'fileName.required'                 => 'Debe ingresar un nombre para el archivo.',
            'fileAttached.required'             => 'Debe ingresar un archivo adjunto.',
        ];
    }

    public function render()
    {
        return view('livewire.purchase-plan.create-purchase-plan');
    }

    #[On('searchedUser')]
    public function searchedUser(User $user){
        $this->searchedUser = $user;

        $this->userResponsibleId = $this->searchedUser->id;
        $this->position = $this->searchedUser->position;
        $this->telephone = ($this->searchedUser->telephones->count() > 0) ? $this->searchedUser->telephones->first()->minsal : '';
        $this->email = $this->searchedUser->email;

        $this->organizationalUnit = $this->searchedUser->organizationalUnit->name;
    }

    #[On('searchedProgram')]
    public function searchedProgram(Program $searchedProgram){
        $this->searchedProgram = $searchedProgram;
        $this->program_id = $searchedProgram->id;
        $this->period = $searchedProgram->period;
    }

    #[On('savedItems')]
    public function savedItems($items)
    {
      $this->items = $items;
    }

    #[On('deletedItems')]
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
        if($this->purchasePlanToEdit && $this->purchasePlanToEdit->getStatus() == "Rechazado"){
            $returnView = 'edit';
        }
        else{
            $returnView = 'show';
        }

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
            'items'             => 'required',
        ]);

        $purchasePlan = DB::transaction(function () {
            $purchasePlan = PurchasePlan::updateOrCreate(
                [
                    'id'  =>  $this->idPurchasePlan,
                ],
                [
                    'user_creator_id'           => auth()->id(), 
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

        $purchasePlan->load('approvals');
        if($purchasePlan->approvals->count() > 0){
            $ous = auth()->user()->amIAuthorityFromOu->pluck('organizational_unit_id')->toArray();
            $iam_approver = $purchasePlan->approvals->where('active', 1)->whereNull('status')->whereIn('sent_to_ou_id', $ous)->count();
            if(!$iam_approver){
                $purchasePlan->approvals()->delete();
                $purchasePlan->update(['status' => 'save']);
            }
        }

        if($this->files){
            foreach($this->files as $file){
                $now = now()->format('Y_m_d_H_i_s');
                $purchasePlan->files()->updateOrCreate(
                    [
                        'id'            => $file['id'] ? $file['id'] : null,
                    ],
                    [
                        'storage_path'  => $file['file'],
                        'stored'        => true,
                        'name'          => $file['fileName'],
                        'stored_by_id'  => auth()->id(),
                    ]
                );
            }
        }
        
        if($returnView == 'edit'){
            return redirect()->route('purchase_plan.edit', $purchasePlan->id);
        }
        else{
            return redirect()->route('purchase_plan.show', $purchasePlan->id);
        }
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

            foreach($this->purchasePlanToEdit->files as $file){
                $this->setFiles($file);
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
            if($this->purchasePlanToEdit->approvals()->where('approver_ou_id', Parameter::get('ou', 'AbastecimientoSSI'))->exists())
                $this->disabled = 'disabled';
        }
    }

    /* Metodos para Archivos */
    public function addFile(){
        $this->validateMessage = 'file';
        $validatedData = $this->validate([
            'fileName'      => 'required',
            'fileAttached'  => 'required' 
        ]);

        $count = ($this->files == null) ? 0 : count($this->files); 

        $now = now()->format('Y_m_d_H_i_s');
        $this->fileStoragePath = $this->fileAttached->storeAs('/ionline/purchase_plan/attachments', $now.'_'.$count.'_purchase_plan_file.'.$this->fileAttached->extension(), 'gcs');

        $this->files[] = [
            'id'        => '',
            'fileName'  => $this->fileName.'.'.$this->fileAttached->extension(),
            'file'      => $this->fileStoragePath
        ];

        $this->cleanFile();
    }

    public function cleanFile(){   
        $this->fileName     = null;
        $this->fileAttached = null;
        $this->iterationFileClean++;
    }

    private function setFiles($file){
        $this->files[] = [
            'id'        => $file->id,
            'fileName'  => $file->name,
            'file'      => $file->storage_path
        ];
    }

    public function showFile($key){
        $file = File::where('id', $fileId)->first();
        return Storage::response($file->storage_path);
    }

    public function deleteFile($key){
        $fileToDelete = $this->files[$key];
        $objectToDelete = File::find($fileToDelete['id']);
        if($objectToDelete){
            $purchasePlan = $objectToDelete->fileable;
        }

        if($fileToDelete['id'] != ''){
            if(str_contains(strtolower($purchasePlan->program), 'institucional')){
                // ELIMINAR SI ES PRESUPUESTO INSTITUCIONAL
                if(count($this->files) > 1){
                    unset($this->files[$key]);
                    $objectToDelete = File::find($itemToDelete['id']);
                    $objectToDelete->delete();
                }
                else{
                    $this->deleteFileMessage = "Estimado Usuario: No es posible eliminar el adjunto, el Plan de Compras con cargo institucional debe incluír al menos un archivo adjunto.";
                }
            }
            else{
                // ELIMINAR SI NO ES PRESUPUESTO INSTITUCIONAL
                unset($this->files[$key]);
                $objectToDelete = File::find($fileToDelete['id']);
                $objectToDelete->delete();
            }
        }
        else{
            unset($this->files[$key]);
        }
    }
}
