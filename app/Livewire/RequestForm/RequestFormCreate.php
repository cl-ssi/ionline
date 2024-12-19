<?php

namespace App\Livewire\RequestForm;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\RequestFormFile;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\Passenger;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\UnitOfMeasurement;
use App\Models\Parameters\PurchaseMechanism;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Models\Rrhh\Authority;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRequestFormNotification;
use App\Mail\RequestFormSignNotification;
use App\Models\Parameters\Parameter;
use App\Models\Parameters\Program;
use App\Models\PurchasePlan\PurchasePlan;
use Illuminate\Contracts\Validation\Validator;

class RequestFormCreate extends Component
{
        use WithFileUploads;

        public $article, $unitOfMeasurement, $technicalSpecifications, $quantity, $typeOfCurrency, $articleFile, $subtype,
                        $unitValue, $taxes, $fileItem, $totalValue, $lstUnitOfMeasurement, $title, $edit, $key, $request_form_id, $purchasePlan;

        public $name, $contractManagerId, $contractManagerOuId, $contractManager, $superiorChief, $purchaseMechanism, $messagePM, $isHAH,
                        $program, $fileRequests = [], $justify, $totalDocument, $technicalReviewOuId;

        public $items, $lstBudgetItem, $requestForm, $editRF, $deletedItems, $idRF, $savedFiles;
        public $budget_item_id, $lstPurchaseMechanism;

        public $passengers, $deletedPassengers;

        public $searchedUser, $isRFItems;

        public $form_status, $lstProgram, $program_id;

        public $period, $disabled;


        protected function rules(){
            return [
                'name'                         =>  'required',
                'contractManagerId'            =>  'required',
                'subtype'                      =>  'required',
                'purchaseMechanism'            =>  'required',
                // 'program'                      =>  'exclude_unless:program_id,other|required',
                // 'program_id'                   =>  'exclude_if:program_id,other|required',
                'program_id'                   =>  'required',
                'justify'                      =>  'required',
                'typeOfCurrency'               =>  'required',
                'fileRequests'                 =>  (!$this->editRF) ? 'required' : '',
                ($this->isRFItems ? 'items' : 'passengers') => 'required'
            ];
        }

        protected function messages(){
            return [
                'name.required'                =>  'Debe ingresar un "Nombre de formulario".',
                'contractManagerId.required'   =>  'Debe ingresar un "Administrador de Contrato".',
                'subtype.required'             =>  'Seleccione un "Tipo" para este formulario.',
                'purchaseMechanism.required'   =>  'Seleccione un "Mecanismo de Compra".',
                'program.required'             =>  'Ingrese un "Programa Asociado".',
                'program_id.required'          =>  'Seleccione un "Programa Asociado".',
                'fileRequests.required'        =>  'Debe agregar los archivos solicitados',
                'justify.required'             =>  'Debe agregar una "Justificación de Adquisición".',
                'typeOfCurrency.required'      =>  'Ingrese un "Tipo de Moneda"',
                ($this->isRFItems ? 'items.required' : 'passengers.required') => ($this->isRFItems ? 'Debe agregar al menos un Item para Bien y/o Servicio' : 'Debe agregar al menos un Pasajero')
            ];
        }

        public function mount($requestForm, $purchasePlan = null){
            $this->isRFItems = request()->route()->getName() == 'request_forms.items.create' || ($requestForm && $requestForm->type_form == 'bienes y/o servicios');
            $this->purchaseMechanism      = "";
            $this->totalDocument          = 0;
            $this->items                  = array();
            $this->passengers             = array();
            $this->deletedItems           = array();
            $this->title                  = "Agregar Item";
            $this->edit                   = false;
            $this->editRF                 = false;
            $this->lstUnitOfMeasurement   = UnitOfMeasurement::all();
            $this->lstPurchaseMechanism   = PurchaseMechanism::all();
            $estab_hetg = Parameter::get('establishment', 'HETG');
            // if(auth()->user()->establishment_id == $estab_hetg){
            //   $this->lstProgram = Program::with('Subtitle')->where('establishment_id', $estab_hetg)->orderBy('alias_finance')->get();
            // }else{
            //   $this->lstProgram = Program::with('Subtitle')->orderBy('alias_finance')->get();
            // }
            $this->lstProgram = Program::with('Subtitle')->where('establishment_id', auth()->user()->establishment_id == $estab_hetg ? $estab_hetg : NULL)->orderBy('alias_finance')->get();

            // if(auth()->user()->OrganizationalUnit->establishment_id == $estab_hah){
            //   $this->superiorChief = 1;
            //   $this->isHAH = true;
            // }

            if(!is_null($requestForm)){
                $this->requestForm = $requestForm;
                $this->setRequestForm();
            }

            if(!is_null($purchasePlan)){
                $this->purchasePlan = $purchasePlan;
                $this->setRequestFormFromPurchasePlan();
            }
        }

        #[On('savedPassengers')]
        public function savedPassengers($passengers)
        {
            $this->passengers = $passengers;
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

        #[On('deletedPassengers')]
        public function deletedPassengers($items)
        {
            $this->deletedPassengers = $items;
        }

        private function setRequestForm(){
            $this->request_form_id    =   $this->requestForm->request_form_id;
            $this->subtype            =   $this->requestForm->subtype;
            $this->name               =   $this->requestForm->name;
            $this->contractManagerId  =   $this->requestForm->contract_manager_id;
            $this->contractManagerOuId=   $this->requestForm->contract_manager_ou_id;
            $this->contractManager    =   $this->requestForm->contractManager;
            $this->superiorChief      =   $this->requestForm->superior_chief;
            $this->period             =   $this->requestForm->associateProgram->period;
            $this->program            =   $this->requestForm->program;
            $this->searchedProgram    =   $this->requestForm->associateProgram;

            $this->program_id         =   $this->requestForm->associateProgram->id;
            $this->justify            =   $this->requestForm->justification;
            $this->purchaseMechanism  =   $this->requestForm->purchase_mechanism_id;
            $this->typeOfCurrency     =   $this->requestForm->type_of_currency;
            $this->editRF             =   true;
            $this->idRF               =   $this->requestForm->id;
            $this->savedFiles         =   $this->requestForm->requestFormFiles;
            if($this->isRFItems)
                foreach($this->requestForm->itemRequestForms as $item)
                    $this->setItems($item);
            else
                foreach($this->requestForm->passengers as $passenger)
                    $this->setPassengers($passenger);
        }

        private function setRequestFormFromPurchasePlan(){
            $this->name               =   $this->purchasePlan->subject;
            $this->program_id         =   $this->purchasePlan->program_id;
            $this->justify            =   $this->purchasePlan->description."\n".$this->purchasePlan->purpose;
            $this->typeOfCurrency     =   "peso";
        }

        private function setItems($item){
            $this->items[]=[
                        'id'                       => $item->id,
                        'product_id'               => $item->product_id,
                        'unitOfMeasurement'        => $item->unit_of_measurement,
                        'technicalSpecifications'  => $item->specification,
                        'quantity'                 => $item->quantity,
                        'unitValue'                => $item->unit_value,
                        'taxes'                    => $item->tax,
                        'totalValue'               => $item->expense,
                        'articleFile'              => $item->article_file
            ];
        }

        private function setPassengers($passenger)
        {
            $this->passengers[]=[
                'id'                =>  $passenger->id,
                'passenger_type'    =>  $passenger->passenger_type,
                'document_type'     =>  $passenger->document_type,
                'document_number'   =>  $passenger->document_number,
                'run'               =>  $passenger->run,
                'dv'                =>  $passenger->dv,
                'name'              =>  $passenger->name,
                'fathers_family'    =>  $passenger->fathers_family,
                'mothers_family'    =>  $passenger->mothers_family,
                'birthday'          =>  $passenger->birthday->format('Y-m-d'),
                'phone_number'      =>  $passenger->phone_number,
                'email'             =>  $passenger->email,
                'round_trip'        =>  $passenger->round_trip,
                'origin'            =>  $passenger->origin,
                'destination'       =>  $passenger->destination,
                'departure_date'    =>  $passenger->departure_date->format('Y-m-d\TH:i'),
                'return_date'       =>  $passenger->return_date ? $passenger->return_date->format('Y-m-d\TH:i') : null,
                'baggage'           =>  $passenger->baggage,
                'unitValue'         =>  $passenger->unit_value
            ];
        }

     public function messageMechanism(){
            $this->messagePM = array();
            switch ($this->purchaseMechanism) {
                    case 1: // MENORES A 3 UTM.
                            $this->messagePM[] = "Especificaciones Técnicas";
                            break;
                    case 2: //Convenio Marco
                            $this->messagePM[] = "Adjuntar ID Mercado Público";
                            $this->messagePM[] = "Especificaciones Técnicas";
                            $this->messagePM[] = "Decretos Presupuestarios, si procede.";
                            $this->messagePM[] = "Convenios Mandatos, si procede.";
                            $this->messagePM[] = "Resoluciones Aprobatorias de Programa Ministeriales, si procede.";
                            break;
                    case 3: // Trato Directo
                            $this->messagePM[] = "Términos de Referencia y Especificaciones Técnicas.";
                            $this->messagePM[] = "Decretos Presupuestarios, si procede.";
                            $this->messagePM[] = "Convenios Mandatos, si procede.";
                            $this->messagePM[] = "Resoluciones Aprobatorias de Programa Ministeriales, si procede.";
                            $this->messagePM[] = "En el caso de realizar ADDENDUM O RENOVACIONES en los convenios
                                                                        vigentes, se debe adjuntar lo siguiente: Informe técnico que señale
                                                                        la justificación de la adquisición, una cotización por parte de la
                                                                        empresa que indique la compra asociada, y un correo de respaldo que
                                                                        la empresa acepta la nueva adquisición.";
                            break;
                    case 4: //LICITACIÓN PÚBLICA
                            $this->messagePM[] = "Bases y  Especificaciones Técnicas.";
                            $this->messagePM[] = "Decretos Presupuestarios, si procede.";
                            $this->messagePM[] = "Convenios Mandatos, si procede.";
                            $this->messagePM[] = "Resoluciones Aprobatorias de Programa Ministeriales, si procede.";
                            $this->messagePM[] = "En el caso de realizar ADDENDUM O RENOVACIONES en los convenios
                                                                        vigentes, se debe adjuntar lo siguiente: Informe técnico que señale
                                                                        la justificación de la adquisición, una cotización por parte de la
                                                                        empresa que indique la compra asociada, y un correo de respaldo que
                                                                        la empresa acepta la nueva adquisición.";
                            break;
                    case 5: //COMPRA ÁGIL
                            $this->messagePM[] = "Especificaciones Técnicas";
                            $this->messagePM[] = "Decretos Presupuestarios, si procede.";
                            $this->messagePM[] = "Convenios Mandatos, si procede.";
                            $this->messagePM[] = "Resoluciones Aprobatorias de Programa Ministeriales, si procede.";
                            break;
            }
        }

        public function totalForm(){
            $total = 0;
            foreach($this->isRFItems ? $this->items : $this->passengers as $item)
                $total += $item[$this->isRFItems ? 'totalValue' : 'unitValue'];
                // $total += $this->typeOfCurrency == 'peso' ? round($item[$this->isRFItems ? 'totalValue' : 'unitValue']) : $item[$this->isRFItems ? 'totalValue' : 'unitValue'];

            return $this->typeOfCurrency == 'peso' ? round($total) : $total;
        }

        private function createFolio(){
                $startOfYear = Carbon::now()->startOfYear();
                $endOfYear = Carbon::now()->endOfYear();
                $counter = RequestForm::withTrashed()->whereNull('request_form_id')->where('created_at', '>=' , $startOfYear)->where('created_at', '<=', $endOfYear)->count();
                return Carbon::now()->year.'-'.$counter;
        }

        public function saveRequestForm($form_status){
            $this->form_status = $form_status;

            $this->withValidator(function (Validator $validator) {
                $validator->after(function ($validator) {
                        if ($this->available_balance_purchases_exceeded()) {
                             return $validator->errors()->add('balance', 'Saldo disponible para compras del formulario de requerimiento principal excedido con los items y montos registrados en este suministro. Saldo disponible: '.number_format($this->requestForm->father->purchasingProcess->getExpense() - $this->requestForm->father->getTotalExpense(),0,",","."));
                        }
                });
            })->validate();

            $req = DB::transaction(function () {
                if($this->form_status == 'sent'){
                        $req = RequestForm::updateOrCreate(
                            [
                                'id'                    =>  $this->idRF,
                            ],
                            [
                                'subtype'               =>  $this->subtype,
                                'contract_manager_id'   =>  $this->contractManagerId,
                                //contractManagerId
                                //'contract_manager_id'   =>  Authority::getBossFromUser$this->contractManagerId,
                                'contract_manager_ou_id' => $this->contractManagerOuId,
                                // 'contract_manager_ou_id' => User::with('organizationalUnit')->find($this->contractManagerId)->organizationalUnit->establishment_id == Parameter::where('parameter', 'HospitalAltoHospicio')->first()->value 
                                //                             ? User::find($this->contractManagerId)->organizational_unit_id
                                //                             : Authority::getBossFromUser($this->contractManagerId,Carbon::now())->organizational_unit_id,
                                'name'                  =>  $this->name,
                                'superior_chief'        =>  $this->superiorChief,
                                'justification'         =>  $this->justify,
                                'type_form'             =>  $this->isRFItems ? 'bienes y/o servicios' : 'pasajes aéreos',
                                'request_user_id'       =>  $this->editRF ? $this->requestForm->request_user_id : auth()->user()->id,
                                'request_user_ou_id'    =>  $this->editRF ? $this->requestForm->request_user_ou_id : auth()->user()->organizational_unit_id,
                                'estimated_expense'     =>  $this->totalForm(),
                                'type_of_currency'      =>  $this->typeOfCurrency,
                                'purchase_mechanism_id' =>  $this->purchaseMechanism,
                                'program'               =>  $this->program_id == 'other' ? $this->program : null,
                                'program_id'            =>  $this->program_id != 'other' ? $this->program_id : null,
                                'status'                =>  'pending',
                                'purchase_plan_id'      => $this->purchasePlan ? $this->purchasePlan->id : null
                        ]);
                }
                else{
                        $req = RequestForm::updateOrCreate(
                            [
                                'id'                    =>  $this->idRF,
                            ],
                            [
                                'subtype'               =>  $this->subtype,
                                'contract_manager_id'   =>  $this->contractManagerId,
                                //contractManagerId
                                //'contract_manager_id'   =>  Authority::getBossFromUser$this->contractManagerId,
                                // 'contract_manager_ou_id' => $this->editRF && $this->requestForm->contract_manager_id == $this->contractManagerId ? $this->requestForm->contract_manager_id : Authority::getBossFromUser($this->contractManagerId,Carbon::now())->organizational_unit_id,
                                'contract_manager_ou_id'=>  $this->contractManagerOuId,
                                'name'                  =>  $this->name,
                                'superior_chief'        =>  $this->superiorChief,
                                'justification'         =>  $this->justify,
                                'type_form'             =>  $this->isRFItems ? 'bienes y/o servicios' : 'pasajes aéreos',
                                'request_user_id'       =>  $this->editRF ? $this->requestForm->request_user_id : auth()->user()->id,
                                'request_user_ou_id'    =>  $this->editRF ? $this->requestForm->request_user_ou_id : auth()->user()->organizational_unit_id,
                                'estimated_expense'     =>  $this->editRF && $this->requestForm->has_increased_expense ? $this->requestForm->estimated_expense : $this->totalForm(),
                                'type_of_currency'      =>  $this->typeOfCurrency,
                                'purchase_mechanism_id' =>  $this->purchaseMechanism,
                                'program'               =>  $this->program_id == 'other' ? $this->program : null,
                                'program_id'            =>  $this->program_id != 'other' ? $this->program_id : null,
                                'status'                =>  $this->editRF ? $this->requestForm->status->value : 'saved',
                                'purchase_plan_id'      => $this->purchasePlan ? $this->purchasePlan->id : null
                        ]);
                }

                if($this->isRFItems){
                    // save items
                    foreach($this->items as $item){
                        ItemRequestForm::updateOrCreate(
                            [
                                'id'                    =>      $item['id'],
                            ],
                            [
                                'request_form_id'       =>      $req->id,
                                'unit_of_measurement'   =>      $item['unitOfMeasurement'],
                                'specification'         =>      $item['technicalSpecifications'],
                                'quantity'              =>      $item['quantity'],
                                'unit_value'            =>      $item['unitValue'],
                                'product_id'            =>      $item['product_id'],
                                'tax'                   =>      $item['taxes'],
                                'expense'               =>      $item['totalValue'],
                                'article_file'          =>      $item['articleFile']
                        ]);
                    }
                } else {
                    foreach($this->passengers as $passenger){
                        // save passengers
                        Passenger::updateOrCreate(
                            [
                                'id'                =>  $passenger['id'],
                            ],
                            [
                                'user_id'           =>  auth()->user()->id,
                                'passenger_type'    =>  $passenger['passenger_type'],
                                'document_type'     =>  $passenger['document_type'],
                                'document_number'   =>  $passenger['document_number'],
                                'run'               =>  $passenger['run'],
                                'dv'                =>  $passenger['dv'],
                                'name'              =>  $passenger['name'],
                                'fathers_family'    =>  $passenger['fathers_family'],
                                'mothers_family'    =>  $passenger['mothers_family'],
                                'birthday'          =>  $passenger['birthday'],
                                'phone_number'      =>  $passenger['phone_number'],
                                'email'             =>  $passenger['email'],
                                'round_trip'        =>  $passenger['round_trip'],
                                'origin'            =>  $passenger['origin'],
                                'destination'       =>  $passenger['destination'],
                                'departure_date'    =>  $passenger['departure_date'],
                                'return_date'       =>  $passenger['return_date'],
                                'baggage'           =>  $passenger['baggage'],
                                'unit_value'        =>  $passenger['unitValue'],
                                'request_form_id'   =>  $req->id
                            ]);
                    }
                }

                if($this->editRF){
                    // Editar formulario que ya tenga aprobaciones hechas
                    if($this->form_status == 'save' && $this->requestForm && $this->requestForm->hasEventRequestForms()){
                        if(in_array($this->requestForm->status->value, ['pending', 'rejected'])){
                            $this->requestForm->eventRequestForms()->delete();
                            $this->requestForm->update(['status' => 'pending']);
                            if($this->technicalReviewOuId){
                                $req->technical_review_ou_id = $this->technicalReviewOuId;
                                EventRequestform::createTechnicalReviewEvent($req);
                            }
                            EventRequestform::createLeadershipEvent($req);
                            EventRequestform::createPreFinanceEvent($req);
                            EventRequestform::createFinanceEvent($req);
                            EventRequestform::createSupplyEvent($req);

                            $req->edited = true; //se informa re-ingreso formulario a notificaciones

                            //Envío de notificación a Adm de Contrato y abastecimiento.
                            $mail_contract_manager = User::select('email')
                                ->where('id', $req->contract_manager_id)
                                ->first();

                            if($mail_contract_manager){
                                    $emails = [$mail_contract_manager];
                                    Mail::to($emails)
                                        ->cc(env('APP_RF_MAIL'))
                                        ->send(new NewRequestFormNotification($req));
                            }
                            //---------------------------------------------------------

                            //Envío de notificación para visación.
                            // $now = Carbon::now();
                            //manager
                            $type = 'manager';
                            $mail_notification_ou_manager = Authority::getAuthorityFromDate($req->eventRequestForms->first()->ou_signer_user, now(), $type);

                            
                            if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
                                if($mail_notification_ou_manager){
                                        $emails = [$mail_notification_ou_manager->user->email];
                                        Mail::to($emails)
                                            ->cc(env('APP_RF_MAIL'))
                                            ->send(new RequestFormSignNotification($req, $req->eventRequestForms->first()));
                                }
                            }
                        }

                        if($this->requestForm->status->value == 'approved'){
                            $idsToDelete =$this->requestForm->eventRequestForms->whereIn('event_type', ['pre_finance_event', 'finance_event', 'supply_event'])->pluck('id');
                            EventRequestForm::destroy($idsToDelete);
                            //Se vuelve a generar solicitudes de firma para refrendacion en adelante
                            EventRequestform::createPreFinanceEvent($req);
                            EventRequestform::createFinanceEvent($req);
                            EventRequestform::createSupplyEvent($req);
                            $this->requestForm->update(['status' => 'pending', 'signatures_file_id' => null, 'approved_at' => null]);
                            $this->requestForm->purchasers()->detach();
                        }
                        //---------------------------------------------------------

                        session()->flash('info', 'Formulario de requerimiento N° '.$req->folio.' fue editado con exito.');
                    }

                    if($this->form_status == 'sent'){
                            if($this->technicalReviewOuId){
                                    $req->technical_review_ou_id = $this->technicalReviewOuId;
                                    EventRequestform::createTechnicalReviewEvent($req);
                            }
                            EventRequestform::createLeadershipEvent($req);
                            EventRequestform::createPreFinanceEvent($req);
                            EventRequestform::createFinanceEvent($req);
                            EventRequestform::createSupplyEvent($req);

                            //Envío de notificación a Adm de Contrato y abastecimiento.
                            $mail_contract_manager = User::select('email')
                                ->where('id', $req->contract_manager_id)
                                ->first();

                            if($mail_contract_manager){
                                    $emails = [$mail_contract_manager];
                                    Mail::to($emails)
                                        ->cc(env('APP_RF_MAIL'))
                                        ->send(new NewRequestFormNotification($req));
                            }
                            //---------------------------------------------------------

                            //Envío de notificación para visación.
                            // $now = Carbon::now();
                            //manager
                            $type = 'manager';
                            $mail_notification_ou_manager = Authority::getAuthorityFromDate($req->eventRequestForms->first()->ou_signer_user, now(), $type);
                            //secretary
                            // $type_adm = 'secretary';
                            // $mail_notification_ou_secretary = Authority::getAuthorityFromDate($req->eventRequestForms->first()->ou_signer_user, Carbon::now(), $type_adm);
                            
                            if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
                                if($mail_notification_ou_manager){
                                        $emails = [$mail_notification_ou_manager->user->email];
                                        Mail::to($emails)
                                            ->cc(env('APP_RF_MAIL'))
                                            ->send(new RequestFormSignNotification($req, $req->eventRequestForms->first()));
                                }
                            }
                            //---------------------------------------------------------

                            session()->flash('info', 'Formulario de requerimiento N° '.$req->folio.' fue creado con exito.');
                    }

                    $this->isRFItems ? ItemRequestForm::destroy($this->deletedItems) : Passenger::destroy($this->deletedPassengers);
                    session()->flash('info', 'Formulario de requerimiento N° '.$req->folio.' fue editado con exito.');
                }
                else{ // nuevo formulario de requerimiento
                    $req->update(['folio' => $this->createFolio()]);
                    if($this->form_status == 'sent'){
                            if($this->technicalReviewOuId){
                                    $req->technical_review_ou_id = $this->technicalReviewOuId;
                                    EventRequestform::createTechnicalReviewEvent($req);
                            }
                            EventRequestform::createLeadershipEvent($req);
                            EventRequestform::createPreFinanceEvent($req);
                            EventRequestform::createFinanceEvent($req);
                            EventRequestform::createSupplyEvent($req);

                            //Envío de notificación a Adm de Contrato y abastecimiento.
                            $mail_contract_manager = User::select('email')
                                ->where('id', $req->contract_manager_id)
                                ->first();

                            if($mail_contract_manager){
                                    $emails = [$mail_contract_manager];
                                    Mail::to($emails)
                                        ->cc(env('APP_RF_MAIL'))
                                        ->send(new NewRequestFormNotification($req));
                            }
                            //---------------------------------------------------------

                            //Envío de notificación para visación.
                            // $now = Carbon::now();
                            //manager
                            $type = 'manager';
                            $mail_notification_ou_manager = Authority::getAuthorityFromDate($req->eventRequestForms->first()->ou_signer_user, now(), $type);
                            //secretary
                            // $type_adm = 'secretary';
                            // $mail_notification_ou_secretary = Authority::getAuthorityFromDate($req->eventRequestForms->first()->ou_signer_user, Carbon::now(), $type_adm);

                            
                            if($mail_notification_ou_manager){
                                    $emails = [$mail_notification_ou_manager->user->email];
                                    Mail::to($emails)
                                        ->cc(env('APP_RF_MAIL'))
                                        ->send(new RequestFormSignNotification($req, $req->eventRequestForms->first()));
                            }
                            //---------------------------------------------------------

                            session()->flash('info', 'Formulario de requerimiento N° '.$req->folio.' fue creado con exito.');
                    }
                }

                // Se guarda los archivos del form req cuando ya todo lo anteior se guardó exitosamente
                foreach($this->fileRequests as $nFiles => $fileRequest){
                    $reqFile = new RequestFormFile();
                    $now = Carbon::now()->format('Y_m_d_H_i_s');
                    $file_name = $now.'_req_file_'.$nFiles;
                    $reqFile->name = $fileRequest->getClientOriginalName();
                    $reqFile->file = $fileRequest->storeAs('/ionline/request_forms/request_files', $file_name.'.'.$fileRequest->extension(), 'gcs');
                    $reqFile->request_form_id = $this->editRF ? $this->requestForm->id : $req->id;
                    $reqFile->user_id = auth()->user()->id;
                    $reqFile->save();
                }

                return $req;

            });

            return redirect()->route('request_forms.show', $this->editRF ? $this->requestForm->id : $req->id);
        }

        public function btnCancelRequestForm(){
            return redirect()->to('/request_forms/my_forms');
        }

        public function destroyFile($id)
        {
            $requestFormFile = RequestFormFile::find($id);
            Storage::delete($requestFormFile->file);
            $requestFormFile->delete();

            $this->savedFiles = RequestFormFile::where('request_form_id', $this->requestForm->id)->get();
        }

        public function render(){
                $this->messageMechanism();
                // $users = User::where('organizational_unit_id', auth()->user()->organizational_unit_id)->orderBy('name', 'ASC')->get();
                // $users = User::where('external', 0)
                //   ->orderBy('name', 'ASC')
                //   ->get(['id', 'name', 'fathers_family', 'mothers_family']); //get specific columns equals best perfomance bench
                return view('livewire.request-form.request-form-create');
        }

        public function available_balance_purchases_exceeded()
        {
            if($this->requestForm && $this->requestForm->request_form_id){ // es suministro de req. form principal
                //total del monto por items seleccionados en otros suministros + item registrados no debe sobrepasar el total adjudicado al formulario de requerimiento
                $totalItemSelected = 0;
                foreach($this->items as $item)
                        $totalItemSelected += $item['totalValue'];

                $this->requestForm->load('father.purchasingProcess.details');
                return $this->requestForm->father->purchasingProcess->getExpense() - $this->requestForm->father->getTotalExpense() < $totalItemSelected;
            }
            return false;
        }

        public function updatedFileRequests($value)
        {
            $this->fileRequests = $value;
        }

        public function updatedTypeOfCurrency($value){
            $this->dispatch('savedTypeOfCurrency', typeOfCurrency: $value);
        }

        #[On('searchedContractManager')]
        public function searchedContractManager(User $user) {
            $this->contractManagerId = $user->id;
            $this->contractManagerOuId = $user->organizational_unit_id;
        }

        #[On('searchedTechnicalReviewOu')]
        public function searchedTechnicalReviewOu(OrganizationalUnit $organizationalUnit){
            $this->technicalReviewOuId = $organizationalUnit->id;
        }

        // NUEVA SELECCION DE PROGRAMAS
        public function updatedPeriod($value)
        {
            $this->dispatch('contentChanged', contentChanged: $value);
        }
        
        #[On('clearSearchedProgram')]
        public function clearSearchedProgram(){
            $this->searchedProgram = null;
            $this->program_id = null;
        }

        #[On('searchedProgram')]
        public function searchedProgram(Program $searchedProgram){
            $this->searchedProgram = $searchedProgram;
            $this->program_id = $searchedProgram->id;
        }
}
